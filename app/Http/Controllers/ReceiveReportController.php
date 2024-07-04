<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\PaymentMethod;
use App\Models\Receive;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReceiveReportController extends Controller
{
    public function index(Request $request)
    {
        $to_date = !empty($request->to_date) ? Carbon::parse($request->to_date)->toDateString() : Carbon::now()->toDateString();
        $from_date = !empty($request->from_date) ? Carbon::parse($request->from_date)->toDateString() : null;

        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['site_id'] = $request->site_id;
        $data['account_id'] = $request->account_id;
        $data['site_bank_name'] = $request->site_bank_name;
        $data['district'] = $request->district;
        $data['area'] = $request->area;
        $data['payment_method'] = $request->payment_method;


        $data['sites']          = Site::whereHas('receive')->orderBy('name', 'asc')->get();
        $data['districts']      = Receive::where('district', '!=', '')->get()->unique('district');
        $data['areas']          = Receive::where('area', '!=', null)->get()->unique('area');
        $data['accounts']       = BankAccount::orderBy('name', 'asc')->get();
        // $data['accounts']       = Payment::where('site_bank_name','!=', null)->distinct()->select('site_bank_name')->get();
        $data['payment_methods'] = PaymentMethod::orderBy('name', 'asc')->get();


        if (!empty($from_date)) {
            $query = Receive::whereDate('date', '>=', $request->from_date)->whereDate('date', '<=', $to_date);
        } else {
            $query = Receive::whereDate('date', '<=', $to_date);
        }
        if ($request->has('site_id') && !empty($request->site_id)) {
            $query->where(['site_id' => $request->site_id]);
        }

        if ($request->has('account_id') && !empty($request->account_id)) {
            $query->where(['account_id' => $request->account_id]);
        }
        if ($request->has('district') && !empty($request->district)) {
            $query->where(['district' => $request->district]);
        }
        if ($request->has('area') && !empty($request->area)) {
            $query->where(['area' => $request->area]);
        }
        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->where(['payment_method' => $request->payment_method]);
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
        $data['account'] = BankAccount::where(['id' => $request->account_id])->first();

        if (!empty($from_date)) {
            $query = Receive::whereDate('date', '>=', $request->from_date)->whereDate('date', '<=', $to_date);
        } else {
            $query = Receive::whereDate('date', '<=', $to_date);
        }
        if ($request->has('site_id') && !empty($request->site_id)) {
            $query->where(['site_id' => $request->site_id]);
        }

        if ($request->has('account_id') && !empty($request->account_id)) {
            $query->where(['account_id' => $request->account_id]);
        }
        $receives = $query->get();

        $from_date = !empty($from_date)? Carbon::parse($from_date)->format('d/y/Y') : null;

        return view('report.receive.print', ['receives' => $receives, 'to_date' => Carbon::parse($to_date)->format('d/y/Y'), 'from_date' => $from_date, 'data' => $data]);
    }
}
