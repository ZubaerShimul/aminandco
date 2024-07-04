<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\PaymentTo;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentReportController extends Controller
{
    
    public function index(Request $request)
    {
        // dd($request->all());
        $to_date = !empty($request->to_date) ? Carbon::parse($request->to_date)->toDateString() : Carbon::now()->toDateString();
        $from_date = !empty($request->from_date) ? Carbon::parse($request->from_date)->toDateString() : null;
        
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['site_id'] = $request->site_id;
        $data['account_id'] = $request->account_id;
        $data['payment_to_id'] = $request->payment_to_id;
        $data['site_bank_name'] = $request->site_bank_name;
        $data['district'] = $request->district;
        $data['area'] = $request->area;
        $data['payment_method'] = $request->payment_method;


        $data['sites']          = Site::whereHas('payment')->orderBy('name', 'asc')->get();
        $data['districts']      = Payment::where('district','!=', '')->get()->unique('district');
        $data['areas']          = Payment::where('area','!=', null)->get()->unique('area');
        $data['payment_tos']    = PaymentTo::whereHas('payment')->orderBy('name', 'asc')->get();
        // $data['accounts']       = BankAccount::orderBy('name', 'asc')->get();
        $data['accounts']       = Payment::where('site_bank_name','!=', null)->distinct()->select('site_bank_name')->get();
        $data['payment_methods'] = PaymentMethod::orderBy('name', 'asc')->get();


        if (!empty($from_date)) {
            $query = Payment::whereDate('date', '>=', $request->from_date)->whereDate('date', '<=', $to_date);
        } else {
            $query = Payment::whereDate('date', '<=', $to_date);
        }
        if ($request->has('site_id') && !empty($request->site_id)) {
            $query->where(['site_id' => $request->site_id]);
        }

        if ($request->has('site_bank_name') && !empty($request->site_bank_name)) {
            $query->where(['site_bank_name' => $request->site_bank_name]);
        }

        if ($request->has('payment_to_id') && !empty($request->payment_to_id)) {
            $query->where(['payment_to_id' => $request->payment_to_id]);
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

        $payments = $query->get();

        return view('report.payment.report', ['data' => $data, 'payments' => $payments]);
    }

    public function print(Request $request)
    {
        $to_date = !empty($request->to_date) ? $request->to_date : Carbon::now()->toDateString();
        $from_date = !empty($request->from_date) ? $request->from_date : null;

        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['site_id'] = $request->site_id;
        $data['payment_to'] = PaymentTo::where('id', $request->payment_to_id)->first();
        $data['site'] = Site::where(['id' => $request->site_id])->first();


        if (!empty($from_date)) {
            $query = Payment::whereDate('date', '>=', $request->from_date)->whereDate('date', '<=', $to_date);
        } else {
            $query = Payment::whereDate('date', '<=', $to_date);
        }
        if ($request->has('site_id') && !empty($request->site_id)) {
            $query->where(['site_id' => $request->site_id]);
        }

        if ($request->has('account_id') && !empty($request->account_id)) {
            $query->where(['account_id' => $request->account_id]);
        }

        if ($request->has('payment_to_id') && !empty($request->payment_to_id)) {
            $query->where(['payment_to_id' => $request->payment_to_id]);
        }
        $payments = $query->get();
        
        return view('report.payment.print', ['payments' => $payments, 'to_date' => $to_date, 'from_date' => $from_date, 'data' => $data]);
    }
}
