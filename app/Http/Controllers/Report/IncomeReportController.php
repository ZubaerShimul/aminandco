<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Site;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomeReportController extends Controller
{

    public function index(Request $request)
    {
        $to_date = !empty($request->to_date) ? $request->to_date : Carbon::now()->toDateString();
        $from_date = !empty($request->from_date) ? $request->from_date : null;

        $data['from_date']  = $from_date;
        $data['to_date']    = $to_date;
        $data['site_id']    = $request->site_id;
        $data['area']       = $request->area;
        $data['division']   = $request->division;
        $data['sites']      = Site::orderBy('name', 'asc')->get();
        $data['divisions']  = Site::orderBy('name', 'asc')->distinct()->select('division')->get();
        $data['areas']      = Site::orderBy('name', 'asc')->distinct()->select('area')->get();

        if (!empty($from_date)) {
            $query = Transaction::whereDate('date', '>=', $request->from_date)->whereDate('date', '<=', $to_date);
        } else {
            $query = Transaction::whereDate('date', '<=', $to_date);
        }

        // search by site       
        if ($request->has('site_id') && !empty($request->site_id)) {
            $query->where(['site_id' => $request->site_id]);
        }
        // search by division
        if ($request->has('division') && !empty($request->division)) {
            $query->whereHas('site', function ($division) use ($request) {
                return $division->where(['division' => $request->division]);
            });
        }
        // search by area
        if ($request->has('area') && !empty($request->area)) {
            $query->whereHas('site', function ($area) use ($request) {
                return $area->where(['area' => $request->area]);
            });
        }

        $transactions = $query->with('site')->get();
        // dd(TransactionResource::collection($transactions));
        return view('report.income.report', ['data' => $data, 'transactions' => $transactions]);
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

        $incomes = $query->with('receive', 'payment', 'expense')->get();
        dd($incomes);

        return view('report.expense.print', ['incomes' => $incomes, 'to_date' => $to_date, 'from_date' => $from_date, 'data' => $data]);
    }
}
