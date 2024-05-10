<?php

namespace App\Http\Services;

use App\Models\BankAccount;
use App\Models\Category;
use App\Models\ExpenseIncome;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BankAccountService
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /*
    * * Acc Account store and update
    */

    public function store($request)
    {

        $accountData = [
            'name'              => $request->name,
            'account_number'    => $request->account_number,
            'branch'            => $request->branch,
            'opening_balance'   => $request->opening_balance ?? 0,
        ];

        try {

            DB::beginTransaction();

            $account = BankAccount::create($accountData);
            // transaction start
            $transaction = $this->transactionService->incomeTransaction($account, new BankAccount(), $account->id, $account->opening_balance, CATEGORY_ID_OPENING_BALANCE);
            if ($transaction['success'] == false) {
                DB::rollBack();
                return errorResponse($transaction['message']);
            }
            // transaction end

            DB::commit();
            return successResponse("Account successfully added");
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return errorResponse($e->getMessage());
        }
    }

    /**
     * update
     */
    public function update($request)
    {
        try {

            $account = BankAccount::where(['id' => $request->edit_id])->first();
            if ($account) {

                $accountData = [
                    'name'              => $request->name,
                    'account_number'    => $request->account_number,
                    'branch'            => $request->branch,
                    'opening_balance'   => $request->opening_balance ?? 0,
                    'balance'           => $account->balance + ($request->opening_balance - $account->opening_balance),
                ];

                DB::beginTransaction();

                // transaction start
                $existTransaction = Transaction::where(['trnxable_id' => $account->id, 'trnxable_type' => MODEL_ACCOUNT, 'type' => CASH_IN])->first();
                if (!empty($existTransaction)) {
                    $trnxDiff =  $request->opening_balance - $existTransaction->cash_in;
                    $existTransaction->update([
                        'cash_in'       =>  $request->opening_balance,
                    ]);
                    $exp_transactions = Transaction::where(['account_id' => $account->id])->where('id', '>=', $existTransaction->id)->get();
                    if (isset($exp_transactions[0])) {
                        foreach ($exp_transactions as $trnx) {
                            $trnx->update(['balance' => $trnx->balance + $trnxDiff]);
                        }
                    }

                    // income
                    $expense = ExpenseIncome::where(['accountable_id' => $account->id, 'accountable_type' => MODEL_ACCOUNT, 'type' => INCOME])->first();
                    if (empty($expense)) {
                        return errorResponse("Transaction income doesn't exists");
                    }
                    $expense->update([
                        // 'user_id'      => Auth::id() ?? 1,
                        'total_amount'    => $request->opening_balance,
                        'grand_total'     => $request->opening_balance,
                    ]);
                } else {
                    return errorResponse("Transaction doesn't exists");
                }
                // transaction end
                $account->update($accountData);
                DB::commit();


                return successResponse("Account successfuly updated");
            } else {
                return errorResponse("Account not found");
            }
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse();
        }
    }

    /*
    * * Acc Account delete
    */

    public function delete($id = null)
    {
        try {
            $account = BankAccount::where(['id' => $id])->first();

            if (!empty($account)) {
                if ($account->is_cash) {
                    return errorResponse($account->name . " account should not be deleted");
                }
                if($account->balance != 0) {
                    return errorResponse(__("Available balance account should not be deleted"));
                }

                DB::beginTransaction();
                $account->delete();
                DB::commit();
                return successResponse("Account successfully deleted");
            }
            return errorResponse("Account not found");
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse($e->getMessage());
        }
    }
}
