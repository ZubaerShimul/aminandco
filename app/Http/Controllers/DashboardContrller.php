<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Payment;
use App\Models\Receive;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardContrller extends Controller
{
    public function index()
    {
//         Receive::withTrashed()->update([
//             'is_draft' => DISABLE
//         ]);
//         Payment::withTrashed()->update([
//             'is_draft' => DISABLE
//         ]);
//         Expense::withTrashed()->update([
//             'is_draft' => DISABLE
//         ]);
        
// dd('ok');
        $data['user'] = Auth::user();

        // receive
        $today_receive = Receive::whereDate('date', Carbon::now()->toDateString())->sum('total');
        $previous_receive = 0;
        $last_receive = Receive::whereDate('date', '<', Carbon::now()->toDateString())->orderBy('id', 'desc')->first();
        if (!empty($last_receive)) {
            $previous_receive =   Receive::whereDate('date', $last_receive->date)->sum('total');
        }

        $data['receive']['today']       = $today_receive;
        $data['receive']['previous']    = $previous_receive;
        $data['receive']['change']      = $today_receive > 0 ? $today_receive - $previous_receive : 0;

        // payment
        $today_payment = Payment::whereDate('date', Carbon::now()->toDateString())->sum('total');
        $previous_payment = 0;
        $last_payment = Payment::whereDate('date', '<', Carbon::now()->toDateString())->orderBy('id', 'desc')->first();
        if (!empty($last_payment)) {
            $previous_payment =   Payment::whereDate('date', $last_payment->date)->sum('total');
        }

        $data['payment']['today']       = $today_payment;
        $data['payment']['previous']    = $previous_payment;
        $data['payment']['change']      = $today_payment > 0 ?$today_payment - $previous_payment : 0;

        // payment
        $today_expense = Expense::whereDate('date', Carbon::now()->toDateString())->sum('amount');
        $previous_expense = 0;
        $last_expense = Expense::whereDate('date', '<', Carbon::now()->toDateString())->orderBy('id', 'desc')->first();
        if (!empty($last_expense)) {
            $previous_expense =   Expense::whereDate('date', $last_expense->date)->sum('amount');
        }

        $data['expense']['today']       = $today_expense;
        $data['expense']['previous']    = $previous_expense;
        $data['expense']['change']      = $today_expense > 0 ? $today_expense - $previous_expense : 0;

        #TODO
        // opening balance
        $last_transaction = Transaction::orderBy('date', 'desc')->orderBy('id', 'desc')->first();
        $yesterday_transaction = Transaction::whereDate('date', '<', Carbon::now()->toDateString())->orderBy('id', 'desc')->first();
        $previous_balance = $yesterday_transaction ? $yesterday_transaction->balance : 0;

        $data['opening_balance']['today']       = $last_transaction->balance;
        // $data['opening_balance']['today']       = $previous_balance + ($today_receive - $today_payment);
        $data['opening_balance']['previous']    = $previous_balance;
        $data['opening_balance']['change']      = $data['opening_balance']['today'] - $previous_balance;
                    
                    $currentDate = \Carbon\Carbon::now();
                    $dates = [];
                    for ($i = 0; $i < 10; $i++) {
                        $dates[] = $currentDate->copy()->subDays($i)->format('d/m');
                    }

                    // Reverse the dates array to have the oldest date first
                    $dates = array_reverse($dates);
                    $incomeData = [];
                    $expenseData = [];

                    for ($i = 0; $i < 10; $i++) {
                        $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
                        $cashIn = \App\Models\Transaction::whereDate('date', $date)
                                    ->where('type', 'Cash in')
                                    ->sum('cash_in');
                        $cashOut = \App\Models\Transaction::whereDate('date', $date)
                                    ->where('type', 'Cash out')
                                    ->sum('cash_out');
                        $incomeData[] = $cashIn;
                        $expenseData[] = $cashOut;
                    }
                    // dd($incomeData);
                    // Reverse the data arrays to match the dates order
                    $incomeData = array_reverse($incomeData);
                    $expenseData = array_reverse($expenseData);
                    $data['series'] = [
                        [
                            'name' => 'Income',
                            'data' => $incomeData,
                        ],
                        [
                            'name' => 'Expense',
                            'data' => $expenseData,
                        ],
                    ];
                    $data['xaxis'] = [
                        'categories' => $dates,
                    ];
        $data['chart'] = $this->chart();
        return view('dashboard', $data);
    }

    public function changeLanguage(Request $request)
    {
        try {
            if (!in_array($request->lang, ['en', 'bn'])) {
                return redirect()->back()->with(['dismiss' => __('Please select proper language')]);
            }
            app()->setLocale($request->lang);
            Session::put('language', $request->lang);
            return redirect()->back()->with(['success' => __('Language changed successfully')]);
        } catch (\Exception $exception) {
            return redirect()->back()->with(['dismiss' => __('Something went wrong!')]);
        }
    }

    private function chart()
    {
        $data = array();
        $date = Carbon::now();

        #TODO: replaced loop by query

        for ($i = 0; $i < 7; $i++) {
            $income = Transaction::whereDate('date', $date->toDateString())->sum('cash_in');
            $expense = Transaction::where('description','!=', TRANSACTION_EMPLOYEE_SALARY)->whereDate('date', $date->toDateString())->sum('cash_in');
            $data[] = [
                'date' => $date->toDateString(),
                'income' => $income,
                'expense' => $expense,
            ];
            $date->subDay();
        }
        return successResponse("Earning Report", $data);
    }
}
