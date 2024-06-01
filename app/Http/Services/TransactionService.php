<?php

namespace App\Http\Services;

use App\Models\Account;
use App\Models\AccountHistory;
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


    public function incomeTransaction($transaction, $transactionable_type, $amount, $description = null)
    {
        try {
            DB::beginTransaction();

            $account = BankAccount::where(['id' => $transaction->account_id])->first();
            if (empty($account)) {
                return errorResponse("Transaction account doesn't exists");
            }
            $account->update(['balance' => $account->balance + $amount]);

            // transaction
            $latestTransaction = Transaction::orderBy('id', 'desc')->first();
            Transaction::create([
                'created_by'    => $transaction->created_by,
                'trnxable_id'   => $transaction->id,
                'trnxable_type' => $transactionable_type,
                'account_id'    => $account ? $account->id : null,
                'description'   => $description,
                'payment_method' => $transaction->payment_method,
                'type'          => CASH_IN,
                'cash_in'       => $amount,
                'date'          => $transaction->date ?? Carbon::now()->toDateString(),
                'balance'       => !empty($latestTransaction) ? $latestTransaction->balance + $amount : $amount,
            ]);

            DB::commit();
            return successResponse();
        } catch (Exception $e) {
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
            DB::beginTransaction();

            // transaction
            $existTransaction = Transaction::where(['trnxable_id' => $transaction->id, 'trnxable_type' => $transactionable_type, 'type' => CASH_IN])->first();
            if (!empty($existTransaction)) {

                $trnxDiff =  $amount - $existTransaction->cash_in;
                $existTransaction->update([
                    'date' => $transaction->date ?? $existTransaction->date,
                    'cash_in' => $amount,
                ]);
                $exp_transactions = Transaction::where('id', '>=', $existTransaction->id)->get();
                if (isset($exp_transactions[0])) {
                    foreach ($exp_transactions as $trnx) {
                        $trnx->update(['balance' => $trnx->balance + $trnxDiff]);
                    }
                }
                //account
                $account->update(['balance' => $account->balance + $trnxDiff]);
            } else {
                return errorResponse("Transaction doesn't exists");
            }
            // transaction end
            DB::commit();
            return successResponse();
        } catch (Exception $e) {

            DB::rollBack();
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
            if (empty($existTransaction)) {
                return errorResponse("Transaction doesn't exists");
            }


            $exp_transactions = Transaction::where('id', '>=', $existTransaction->id)->get();
            if (isset($exp_transactions[0])) {
                foreach ($exp_transactions as $trnx) {
                    $trnx->update(['balance' => $trnx->balance - $existTransaction->cash_in]);
                }
            }

            $account->update(['balance' => $account->balance - $existTransaction->cash_in]);
            $existTransaction->delete();
            // transaction end
            DB::commit();
            return successResponse();
        } catch (Exception $e) {

            DB::rollBack();
            return errorResponse();
        }
    }
}
