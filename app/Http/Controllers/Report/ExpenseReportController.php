<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Expense;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseReportController extends Controller
{
    public function index(Request $request)
    {
        $to_date = !empty($request->to_date) ? $request->to_date : Carbon::now()->toDateString();
        $from_date = !empty($request->from_date) ? $request->from_date : null;

        $data['from_date']  = $from_date;
        $data['to_date']    = $to_date;
        $data['site_id']    = $request->site_id;
        $data['account_id'] = $request->account_id;
        $data['type']       = $request->type;
        $data['sites']      = Site::whereHas('expense')->orderBy('id', 'desc')->get();
        $data['accounts']   = BankAccount::whereHas('expense')->orderBy('name', 'asc')->get();

        if (!empty($from_date)) {
            $query = Expense::whereDate('date', '>=', $request->from_date)->whereDate('date', '<=', $to_date);
        } else {
            $query = Expense::whereDate('date', '<=', $to_date);
        }

        if ($request->has('type') && !empty($request->type)) {
            $query->where(['type' => $request->type]);
        }

        if ($request->has('site_id') && !empty($request->site_id)) {
            $query->where(['site_id' => $request->site_id]);
        }

        if ($request->has('account_id') && !empty($request->account_id)) {
            $query->where(['account_id' => $request->account_id]);
        }
        $expenses = $query->get();

        return view('report.expense.report', ['data' => $data, 'expenses' => $expenses]);
    }

    public function print(Request $request)
    {
        $to_date = !empty($request->to_date) ? $request->to_date : Carbon::now()->toDateString();
        $from_date = !empty($request->from_date) ? $request->from_date : null;

        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['site_id'] = $request->site_id;
        $data['type'] = $request->type;
        $data['site'] = Site::where(['id' => $request->site_id])->first();
        $data['account'] = BankAccount::where(['id' => $request->account_id])->first();


        if (!empty($from_date)) {
            $query = Expense::whereDate('date', '>=', $request->from_date)->whereDate('date', '<=', $to_date);
        } else {
            $query = Expense::whereDate('date', '<=', $to_date);
        }

        if ($request->has('type') && !empty($request->type)) {
            $query->where(['type' => $request->type]);
        }

        if ($request->has('site_id') && !empty($request->site_id)) {
            $query->where(['site_id' => $request->site_id]);
        }

        if ($request->has('account_id') && !empty($request->account_id)) {
            $query->where(['account_id' => $request->account_id]);
        }

        $expenses = $query->get();

        return view('report.expense.print', ['expenses' => $expenses, 'to_date' => $to_date, 'from_date' => $from_date, 'data' => $data]);
    }
}
