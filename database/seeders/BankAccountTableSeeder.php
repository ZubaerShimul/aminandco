<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\ExpenseIncome;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankAccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $account = BankAccount::create([
            'name'      => "Cash",
            'is_cash'   => ENABLE
        ]);

        $transaction = Transaction::create([
            'user_id'       => 1,
            'trnxable_id'   => $account->id,
            'trnxable_type' => MODEL_ACCOUNT,
            'account_id'    => $account->id,
            'type'          => CASH_IN,
            'category_id'   => CATEGORY_ID_OPENING_BALANCE,
            'cash_in'       => 0,
            'date'          => Carbon::now()->toDateString(),
            'balance'       => 0,
        ]);

        $expenseData['user_id']         = 1;
        $expenseData['accountable_id']  = $account->id;
        $expenseData['accountable_type'] = MODEL_ACCOUNT;
        $expenseData['account_id']      = $account->id;
        $expenseData['date']            = $transaction->date ?? Carbon::now()->toDateString();
        $expenseData['payment_method']  = $transaction->payment_method ?? null;
        $expenseData['total_amount']    = 0;
        $expenseData['grand_total']     = 0;
        $expenseData['description']     = $transaction->description ?? null;
        $expenseData['type']            = INCOME;
        $expenseData['category_id']     = CATEGORY_ID_OPENING_BALANCE;

        ExpenseIncome::create($expenseData);
    }
}
