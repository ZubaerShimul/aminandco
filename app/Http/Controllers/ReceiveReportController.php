<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Receive;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReceiveReportController extends Controller
{
    public function index(Request $request)
    {
        $to_date = !empty($request->to_date) ? $request->to_date : Carbon::now()->toDateString();
        $from_date = !empty($request->from_date) ? $request->from_date : null;

        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['site_id'] = $request->site_id;
        $data['account_id'] = $request->account_id;
        $data['sites'] = Site::whereHas('receive')->orderBy('id', 'desc')->get();
        $data['accounts'] = BankAccount::whereHas('receive')->orderBy('name', 'asc')->get();

        if (!empty($from_date)) {
            $query = Receive::whereDate('date', '>=', $request->from_date)->whereDate('date', '<=', $to_date);
        } else {
            $query = Receive::whereDate('date', '<=', $to_date);
        }
        if ($request->has('site_id') && !empty($request->site_id)) {
            $query->where(['site_id' => $request->site_id]);
        }

        if ($request->has('site_id') && !empty($request->account_id)) {
            $query->where(['account_id' => $request->account_id]);
        }
        $receives = $query->get();

        return view('report.receive.report', ['data' => $data, 'receives' => $receives]);
    }

    public function print(Request $request)
    {
        $to_date = !empty($request->to_date) ? $request->to_date : Carbon::now()->toDateString();
        $from_date = !empty($request->from_date) ? $request->from_date : null;

        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['site_id'] = $request->site_id;
        $data['account_id'] = $request->account_id;
        $data['site'] = Site::where(['id' => $request->site_id])->first();
        $data['account'] = BankAccount::where(['id' => $request->account_id])->first();;

        if (!empty($from_date)) {
            $query = Receive::whereDate('date', '>=', $request->from_date)->whereDate('date', '<=', $to_date);
        } else {
            $query = Receive::whereDate('date', '<=', $to_date);
        }
        if ($request->has('site_id') && !empty($request->site_id)) {
            $query->where(['site_id' => $request->site_id]);
        }

        if ($request->has('site_id') && !empty($request->account_id)) {
            $query->where(['account_id' => $request->account_id]);
        }
        $receives = $query->get();


        return view('report.receive.print', ['receives' => $receives, 'to_date' => $to_date, 'from_date' => $from_date, 'data' => $data]);
    }
}
