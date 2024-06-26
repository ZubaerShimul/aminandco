<?php

namespace App\Http\Services;

use App\Models\BankAccount;
use App\Models\Category;
use App\Models\Expense;
use App\Models\ExpenseIncome;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseService
{

    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }


    public function store($request)
    {
        $account    = explode('-', $request->account);
        $site       = explode('-', $request->site);

        $data = [
            'created_by'        => Auth::id(),
            'date'              => !empty($request->date) ? Carbon::parse($request->date)->toDateString() : Carbon::now()->toDateString(),
            'name'              => $request->name,
            'account_id'        => isset($account[0]) && $account[0] != "" ? $account[0] : null,
            'bank_name'         => isset($account[1]) && $account[1] != "" ? $account[1] : null,
            'site_id'           => isset($site[0]) && $site[0] != "" ? $site[0] : null,
            'site_name'         => isset($site[1]) && $site[1] != "" ? $site[1] : null,
            'division'          => isset($site[2]) && $site[2] != "" ? $site[2] : null,
            'area'              => isset($site[3]) && $site[3] != "" ? $site[3] : null,
            'payment_method'    => $request->payment_method,
            'amount'            => $request->amount ?? 0,
            'type'              => $request->type,
            'note'              => $request->note,
        ];

        if (!empty($request->document)) {
            $data['document'] = fileUpload($request->document, DOCUMENT_PATH);
        }

        try {
            DB::beginTransaction();

            // bank account update start
            $bankAccount = BankAccount::where(['id' =>  $data['account_id']])->first();
            if (!empty($bankAccount)) {
                $bankAccount->update([
                    'balance'   => $bankAccount->balance - $data['amount']
                ]);
                // return redirect()->back()->with('dismiss', __("Account not found"));
            }
            // if($bankAccount->balance < $request->total_amount) {
            //     return errorResponse("No available balance");
            // }
            // $bankAccount->update([
            //     'balance'   => $bankAccount->balance - $expenseData['total_amount']
            // ]);

            // expense and details
            $expense = Expense::create($data);
            $transaction = $this->transactionService->expenseTransaction($expense, "App\Models\Expense", $expense->amount, $expense->type);
            if ($transaction['success'] == false) {
                DB::rollBack();
                return errorResponse($transaction['message']);
            }
            DB::commit();
            return successResponse("Expenses succussfully added");
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return errorResponse($e->getMessage());
        }
    }

    # ~~~~~~~~~~~~~~~~~~~~~~~ update ~~~~~~~~~~~~~~~~~~~
    /**
     * update
     */
    public function update($request)
    {
        $account    = explode('-', $request->account);
        $site       = explode('-', $request->site);


        // $bankAccount = BankAccount::where(['id' => $request->account])->first();
        // if (empty($bankAccount)) {
        //     return errorResponse("Account not found");
        // }
        // if($request->amount > $bankAccount->balance) {
        //     return errorResponse("Insufficient account balance");
        // }




        $expense =   Expense::where(['id' => $request->id])->first();
        if (empty($expense)) {
            return errorResponse(__("Expense not found"));
        }

        // if($request->amount > ($account->balance + $expense->amount)) {
        //     return errorResponse("Insufficient account balance");
        // }

        $total = $request->amount;
        $expenseData = [
            'date'              => !empty($request->date) ? Carbon::parse($request->date)->toDateString() : Carbon::now()->toDateString(),
            'name'              => $request->name,
            // 'account_id'        => isset($account[0]) && $account[0] != "" ? $account[0] : null,
            // 'bank_name'         => isset($account[1]) && $account[1] != "" ? $account[1] : null,
            'site_id'           => $request->type == EXPENSE_TYPE_OTHERS ? (isset($site[0]) && $site[0] != "" ? $site[0] : null) : null,
            'site_name'         => $request->type == EXPENSE_TYPE_OTHERS ? (isset($site[1]) && $site[1] != "" ? $site[1] : null) : null,
            'division'          => $request->type == EXPENSE_TYPE_OTHERS ? (isset($site[2]) && $site[2] != "" ? $site[2] : null) : null,
            'area'              => $request->type == EXPENSE_TYPE_OTHERS ? (isset($site[3]) && $site[3] != "" ? $site[3] : null) : null,
            'payment_method'    => $request->payment_method,
            'amount'            => $request->amount ?? 0,
            'type'              => $request->type,
            'note'              => $request->note
        ];

        if (!empty($request->document)) {
            $expenseData['document'] = fileUpload($request->document, DOCUMENT_PATH, $expense->document);
        }

        try {

            DB::beginTransaction();

            // transaction start
            $transaction = $this->transactionService->expenseTransactionUpdate($expense, "App\Models\Expense", $total);
            if ($transaction['success'] == false) {
                DB::rollBack();
                return errorResponse($transaction['message']);
            }
            // transaction end

            $expense->update($expenseData);
            DB::commit();

            return successResponse("Expense successfuly updated");
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse();
        }
    }

    # ~~~~~~~~~~~~~~~~~~~~~~~ Delete ~~~~~~~~~~~~~~~~~~~

    public function delete($id = null)
    {
        try {
            $expense = Expense::where(['id' => $id])->first();
            if (!empty($expense)) {

                DB::beginTransaction();

                $transaction = $this->transactionService->expenseTransactionDelete($expense, "App\Models\Expense");
                if ($transaction['success'] == false) {
                    DB::rollBack();
                    return errorResponse($transaction['message']);
                }
                // transaction end

                $expense->delete();
                DB::commit();
                return successResponse("Expenses successfully deleted");
            }
            return errorResponse('Expenses not found');
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse($e->getMessage());
        }
    }
}
