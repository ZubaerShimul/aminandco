<?php

namespace App\Http\Controllers;

use App\Http\Services\PaymentService;
use App\Models\BankAccount;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\PaymentTo;
use App\Models\Site;
use Illuminate\Http\Request;

class PaymentController extends Controller
{


    private $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_payment = Payment::query();
            return datatables($report_payment)
                ->editColumn('checkin', function ($payment) {
                    return '<input type="checkbox" class="item-checkbox" data-id="' . $payment->id . '">';
                })
                ->addColumn('actions', function ($payment) {
                    $action = '<button type="button"
                    data-date="' . $payment->date . '"
                    data-name="' . $payment->name . '"
                    data-designation="' . $payment->designation . '"
                    data-bank_name="' . $payment->bank_name  . '"
                    data-payment_method="' . $payment->payment_method  . '"
                    data-salary="' . $payment->salary  . '"
                    data-ta_da="' . $payment->ta_da  . '"
                    data-mobile_bill="' . $payment->mobile_bill  . '"
                    data-total="' . $payment->total  . '"
                     class="btn btn-sm  btn-info text-white action-btn" style="margin-right:10px">' . VIEW_ICON . '</button>';
                    // $action .= status_change_modal($payment). '</div>';
                    return $action;
                })
                ->rawColumns(['checkin', 'actions'])
                ->make(TRUE);
        }
        return view('payment.index');
    }

    public function create()
    {
        $data['accounts']           = BankAccount::orderBy('name', 'asc')->get();
        $data['payment_tos']        = PaymentTo::orderBy('name', 'asc')->get();
        $data['payment_methods']     = PaymentMethod::orderBy('name', 'asc')->get();
        $data['sites']              = Site::orderBy('id', 'desc')->get();

        return view('payment.create', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $payment = $this->paymentService->store($request);
        if ($payment['success'] == true) {
            return redirect()->route('payment.list')->with('success', $payment['message']);
        }
        return redirect()->back()->with('dismiss', $payment['message']);
    }

    public function edit($id = null)
    {
        $payment = Payment::where(['id' => $id])->with('account')->first();
        if (!empty($payment)) {
            $data['accounts']           = BankAccount::orderBy('name', 'asc')->get();
            $data['payment_tos']        = PaymentTo::orderBy('name', 'asc')->get();
            $data['payment_methods']     = PaymentMethod::orderBy('name', 'asc')->get();
            $data['sites']              = Site::orderBy('id', 'desc')->get();


            return view('payment.edit', ['payment' => $payment, 'data' => $data]);
        }
        return redirect()->route('payment.list')->with('dismiss', __("Payment. not found"));
    }

    public function update(Request $request)
    {

        $payment = $this->paymentService->update($request);

        if ($payment['success'] == TRUE) {
            return redirect()->route('payment.list')->with('success', $payment['message']);
        }
        return redirect()->back()->with('dismiss', $payment['message']);
    }

    public function delete($id = null)
    {
        $payment = $this->paymentService->delete($id);
        if ($payment['success'] == true) {
            return redirect()->route('payment.list')->with('success', $payment['message']);
        }
        return redirect()->route('payment.list')->with('dismiss', $payment['message']);
    }

    // public function getLaboursByTender($tenderId)
    // {
    //     $labors = Labour::where('tender_id', $tenderId)->get();
    //     return response()->json($labors);
    // }

}
