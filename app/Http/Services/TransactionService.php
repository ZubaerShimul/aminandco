<?php

namespace App\Http\Services;

use App\Models\Account;
use App\Models\BankAccount;
use App\Models\ExpenseIncome;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionService
{

    // ------------------------------ EXPENSE ---------------------------\\
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\\

    public function expenseTransaction($transaction, $transactionable_type,  $amount, $description = null)
    {
        try {

            DB::beginTransaction();

            $account = BankAccount::where(['id' => $transaction->account_id])->first();
            if (!empty($account)) {
                $account->update(['balance' => $account->balance - $amount]);
            }

            // transaction
            $latestTransaction = Transaction::orderBy('id', 'desc')->first();
            Transaction::create([
                'ref'           => $transaction->ref,
                'created_by'   => $transaction->created_by,
                'trnxable_id'   => $transaction->id,
                'trnxable_type' => $transactionable_type,
                'account_id'    => $account ? $account->id : null,
                'description'   => $description,
                'payment_method' => $transaction->payment_method,
                'type'          => CASH_OUT,
                'cash_out'      => $amount,
                'date'          => $transaction->date ?? Carbon::now()->toDateString(),
                'balance'       => !empty($latestTransaction) ? $latestTransaction->balance - $amount : (-$amount),
            ]);

            DB::commit();
            return successResponse();
        } catch (Exception $e) {

            DB::rollBack();


            return dd($e->getMessage());
        }
    }

    # ~~~~~~~~~~~~~~~~~~~~~~~ update ~~~~~~~~~~~~~~~~~~~

    public function expenseTransactionUpdate($transaction, $transactionable_type, $amount)
    {
        try {
            $account = BankAccount::where(['id' => $transaction->account_id])->first();
            DB::beginTransaction();

            // transaction
            $existTransaction = Transaction::where(['trnxable_id' => $transaction->id, 'trnxable_type' => $transactionable_type, 'type' => CASH_OUT])->first();
            if (!empty($existTransaction)) {

                $trnxDiff =  $amount - $existTransaction->cash_out;
                $existTransaction->update([
                    'date' => $transaction->date ?? $existTransaction->date,
                    'cash_out' => $amount,
                    'balance' => $existTransaction->balance - $trnxDiff
                ]);

                $exp_transactions = Transaction::where('id', '>', $existTransaction->id)->get();
                if (isset($exp_transactions[0])) {
                    foreach ($exp_transactions as $trnx) {
                        $trnx->update(['balance' => $trnx->balance - $trnxDiff]);
                    }
                }
                // account updated
                if (!empty($account)) {
                    $account->update(['balance' => $account->balance - $trnxDiff]);
                }
            } else {
                return errorResponse("Transaction doesn't exists");
            }
            // transaction end
            DB::commit();
            return successResponse();
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse();
        }
    }

    # ~~~~~~~~~~~~~~~~~~~~~~~ Delete ~~~~~~~~~~~~~~~~~~~

    public function expenseTransactionDelete($transaction,  $transactionable_type)
    {
        try {

            // account
            $account = BankAccount::where(['id' => $transaction->account_id])->first();

            // if (empty($account)) {
            //     return errorResponse("Transaction account doesn't exists");
            // }

            DB::beginTransaction();

            // transaction
            $existTransaction = Transaction::where(['trnxable_id' => $transaction->id, 'trnxable_type' => $transactionable_type, 'type' => CASH_OUT])->first();
            if (!empty($existTransaction)) {

                $exp_transactions = Transaction::where('id', '>=', $existTransaction->id)->get();
                if (isset($exp_transactions[0])) {
                    foreach ($exp_transactions as $trnx) {
                        $trnx->update(['balance' => $trnx->balance + $existTransaction->cash_out]);
                    }
                }

                if (!empty($account)) {
                    $account->update(['balance' => $account->balance + $existTransaction->cash_out]);
                }
                $existTransaction->delete();
            } else {
                return errorResponse("Transaction doesn't exists");
            }
            // transaction end
            DB::commit();
            return successResponse();
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    // --------------------------------- INCOME ---------------------------------------\\
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\\


    public function incomeTransaction($transaction, $transactionable_type, $account_id, $amount, $income_category_id = null)
    {
        try {
            DB::beginTransaction();

            $account = BankAccount::where(['id' => $account_id])->first();
            if (empty($account)) {
                return errorResponse("Transaction account doesn't exists");
            }
            $account->update(['balance' => $account->balance + $amount]);

            // // bank account update end

            $expenseData['user_id']         = 1;
            $expenseData['tender_id']       = $transaction->tender_id ?? null;
            $expenseData['accountable_id']  = $transaction->id;
            $expenseData['accountable_type'] = $transactionable_type;
            $expenseData['account_id']      = $account_id;
            $expenseData['ref']             = $transaction->ref ?? null;
            $expenseData['date']            = $transaction->date ?? Carbon::now()->toDateString();
            $expenseData['payment_method']  = $transaction->payment_method ?? null;
            $expenseData['total_amount']    = $amount;
            $expenseData['grand_total']     = $amount;
            $expenseData['description']     = $transaction->description ?? null;
            $expenseData['type']            = INCOME;
            $expenseData['category_id']     = $income_category_id;

            ExpenseIncome::create($expenseData);

            // transaction
            $latestTransaction = Transaction::where(['account_id' => $account_id])->orderBy('id', 'desc')->first();
            Transaction::create([
                'ref'           => $transaction->ref,
                'tender_id'     => $transaction->tender_id ?? null,
                'user_id'       => $transaction->user_id ?? 1,
                'trnxable_id'   => $transaction->id,
                'trnxable_type' => $transactionable_type,
                'account_id'    => $account_id,
                'type'          => CASH_IN,
                'category_id'   => $income_category_id,
                'cash_in'       => $amount,
                'date'          => $transaction->date ?? Carbon::now()->toDateString(),
                'balance'  => !empty($latestTransaction) ? $latestTransaction->balance + $amount : $amount,
            ]);

            DB::commit();
            return successResponse();
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return errorResponse();
        }
    }

    # ~~~~~~~~~~~~~~~~~~~~~~~ update ~~~~~~~~~~~~~~~~~~~

    public function incomeTransactionUpdate($transaction, $transactionable_type, $amount)
    {
        try {
            $account = BankAccount::where(['id' => $transaction->account_id])->first();
            if (empty($account)) {
                return errorResponse("Transaction account doesn't exists");
            }
            // DB::beginTransaction();

            // transaction
            $existTransaction = Transaction::where(['trnxable_id' => $transaction->id, 'trnxable_type' => $transactionable_type, 'type' => CASH_IN])->first();
            if (!empty($existTransaction)) {

                $trnxDiff =  $amount - $existTransaction->cash_in;
                $existTransaction->update([
                    'user_id' => $transaction->user_id,
                    'date' => $transaction->date ?? $existTransaction->date,
                    'cash_in' => $amount,
                    'category_id'   => $transaction->category_id ?? $existTransaction->category_id,
                ]);
                $exp_transactions = Transaction::where(['account_id' => $existTransaction->account_id])->where('id', '>=', $existTransaction->id)->get();
                if (isset($exp_transactions[0])) {
                    foreach ($exp_transactions as $trnx) {
                        $trnx->update(['balance' => $trnx->balance + $trnxDiff]);
                    }
                }

                // expense
                $expense = ExpenseIncome::where(['accountable_id' => $transaction->id, 'accountable_type' => $transactionable_type, 'type' => INCOME])->first();
                if (empty($expense)) {
                    return errorResponse("Transaction income doesn't exists");
                }
                $expense->update([
                    'user_id'      => 1,
                    'date'            => $transaction->date ?? $expense->date,
                    'payment_method'  => $transaction->payment_method,
                    'total_amount'    => $amount,
                    'grand_total'     => $amount,
                    'description'           => $transaction->description,
                    'category_id'     => $transaction->category_id ?? $expense->category_id,
                ]);

                //account
                $account->update(['balance' => $account->balance + $trnxDiff]);
            } else {
                return errorResponse("Transaction doesn't exists");
            }
            // transaction end
            // DB::commit();
            return successResponse();
        } catch (Exception $e) {

            // DB::rollBack();
            return errorResponse($e->getMessage());
        }
    }

    # ~~~~~~~~~~~~~~~~~~~~~~~ Delete ~~~~~~~~~~~~~~~~~~~

    public function incomeTransactionDelete($transaction,  $transactionable_type)
    {
        try {
            // account
            $account = BankAccount::where(['id' => $transaction->account_id])->first();
            if (empty($account)) {
                return errorResponse("Transaction account doesn't exists");
            }

            DB::beginTransaction();

            // transaction
            $existTransaction = Transaction::where(['trnxable_id' => $transaction->id, 'trnxable_type' => $transactionable_type, 'type' => CASH_IN])->first();
            if (!empty($existTransaction)) {

                // income
                $income = ExpenseIncome::where(['accountable_id' => $transaction->id, 'accountable_type' => $transactionable_type, 'type' => INCOME])->first();
                if (empty($income)) {
                    return errorResponse("Transaction income doesn't exists");
                }
                $income->delete();

                $exp_transactions = Transaction::where(['account_id' => $existTransaction->account_id])->where('id', '>=', $existTransaction->id)->get();
                if (isset($exp_transactions[0])) {
                    foreach ($exp_transactions as $trnx) {
                        $trnx->update(['balance' => $trnx->balance - $existTransaction->cash_in]);
                    }
                }

                $account->update(['balance' => $account->balance - $existTransaction->cash_in]);
                $existTransaction->delete();
            }

            // else {
            //     return errorResponse("Transaction doesn't exists");
            // }
            // transaction end
            DB::commit();
            return successResponse();
        } catch (Exception $e) {

            DB::rollBack();


            return errorResponse();
        }
    }
}
