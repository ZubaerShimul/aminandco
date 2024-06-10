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
        $data['receive']['change']      = $today_receive - $previous_receive;

        // payment
        $today_payment = Payment::whereDate('date', Carbon::now()->toDateString())->sum('total');
        $previous_payment = 0;
        $last_payment = Payment::whereDate('date', '<', Carbon::now()->toDateString())->orderBy('id', 'desc')->first();
        if (!empty($last_payment)) {
            $previous_payment =   Payment::whereDate('date', $last_payment->date)->sum('total');
        }

        $data['payment']['today']       = $today_payment;
        $data['payment']['previous']    = $previous_payment;
        $data['payment']['change']      = $today_payment - $previous_payment;

        // payment
        $today_expense = Expense::whereDate('date', Carbon::now()->toDateString())->sum('amount');
        $previous_expense = 0;
        $last_expense = Expense::whereDate('date', '<', Carbon::now()->toDateString())->orderBy('id', 'desc')->first();
        if (!empty($last_expense)) {
            $previous_expense =   Expense::whereDate('date', $last_expense->date)->sum('amount');
        }

        $data['expense']['today']       = $today_expense;
        $data['expense']['previous']    = $previous_expense;
        $data['expense']['change']      = $today_expense - $previous_expense;

        #TODO
        // opening balance
        $last_transaction = Transaction::orderBy('date', 'desc')->orderBy('id', 'desc')->first();
        $yesterday_transaction = Transaction::whereDate('date', '<', Carbon::now()->toDateString())->orderBy('id', 'desc')->first();
        $previous_balance = $yesterday_transaction ? $yesterday_transaction->balance : 0;

        $data['opening_balance']['today']       = $last_transaction->balance;
        // $data['opening_balance']['today']       = $previous_balance + ($today_receive - $today_payment);
        $data['opening_balance']['previous']    = $previous_balance;
        $data['opening_balance']['change']      = $data['opening_balance']['today'] - $previous_balance;


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
}
