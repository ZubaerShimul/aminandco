<?php

namespace App\Http\Services;

use App\Models\BankAccount;
use App\Models\Category;
use App\Models\ExpenseIncome;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseService
{

    public function store($bankAccount, $expenseData)
    {
        try {
            DB::beginTransaction();

            $bankAccount->update([
                'balance'   => $bankAccount->balance - $expenseData['total_amount']
            ]);

            // expense and details
            $expense = ExpenseIncome::create($expenseData);

            // transaction
            $latestTransaction = Transaction::where(['account_id' => $bankAccount->id])->orderBy('id', 'desc')->first();
            Transaction::create([
                'tender_id'     => $expense->tender_id,
                'user_id'       => $expense->user_id,
                'trnxable_id'   => $expense->id,
                'trnxable_type' => "App\Models\ExpenseIncome",
                'type'          => CASH_OUT,
                'category_id'   => $expense->category_id,
                'payment_method'=> $expense->payment_method,
                'cash_out'      => $expense->grand_total,
                'date'          => $expense->date,
                'account_id'    => $expense->account_id,
                'balance'  => !empty($latestTransaction) ? $latestTransaction->balance - $expense->grand_total : (-$expense->grand_total),
            ]);
            DB::commit();
            return successResponse("Expenses succussfully added");
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse($e->getMessage());
        }
    }

    # ~~~~~~~~~~~~~~~~~~~~~~~ update ~~~~~~~~~~~~~~~~~~~

    public function update($expense, $bankAccount, $expenseData)
    {
        try {

            DB::beginTransaction();

            $bankAccount->update([
                'balance'   => ($bankAccount->balance + $expense->grand_total)  - $expenseData['total_amount']
            ]);
            // bank account update end

            $expense->update($expenseData);

            // transaction
            $transaction = Transaction::where(['trnxable_id' => $expense->id, 'trnxable_type' => "App\Models\ExpenseIncome", 'type' => CASH_OUT])->first();
            $diff = $expense->grand_total - $transaction->cash_out;

            $transaction->update([
                'user_id' => $transaction->user_id,
                'date' => $expense->date ?? $transaction->date,
                'cash_out' => $expense->grand_total,
                'payment_method' => $expense->payment_method,
                'category_id'   => $expense->category_id ?? $transaction->category_id,
            ]);

            $accounts = Transaction::where(['account_id' => $bankAccount->id])->where('id', '>=',  $transaction->id)->get();

            foreach ($accounts as $acc) {
                $acc->update(['balance'  => $acc->balance - $diff]);
            }
            // transaction end
            $changes =  $expense->getChanges();

            DB::commit();

            return successResponse("Expenses succussfully updated");
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse($e->getMessage() . ' ' . $e->getLine());
        }
    }

    # ~~~~~~~~~~~~~~~~~~~~~~~ Delete ~~~~~~~~~~~~~~~~~~~

    public function delete($id = null)
    {
        try {
            $expense = ExpenseIncome::where(['id' => $id])->first();
            if (!empty($expense)) {
                DB::beginTransaction();

                //bank accunt
                $bankAccount = BankAccount::where('id', $expense->account_id)->first();
                if (empty($bankAccount)) {
                    return errorResponse(__("Account doesn't exists"));
                }
                $bankAccount->update([
                    'balance'   => ($bankAccount->balance + $expense->grand_total)
                ]);

                // transaction
                $transaction = Transaction::where(['trnxable_id' => $expense->id, 'trnxable_type' => "App\Models\ExpenseIncome"])->first();
                if (!empty($transaction)) {
                    $accounts = Transaction::where(['account_id' => $bankAccount->id])->where('id', '>',  $transaction->id)->get();
                    if (isset($accounts[0])) {
                        foreach ($accounts as $acc) {
                            $acc->update(['balance'  => $acc->balance + $transaction->cash_out]);
                        }
                    }
                    $transaction->delete();
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
