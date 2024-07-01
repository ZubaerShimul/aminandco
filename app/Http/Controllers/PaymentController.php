<?php

namespace App\Http\Controllers;

use App\Http\Services\PaymentService;
use App\Models\BankAccount;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\PaymentTo;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            $approved = '<span class="badge bg-success">' . __('Approved') . '</span>';
            $draft = '<span class="badge bg-danger">' . __('Draft') . '</span>';

            return datatables($report_payment)
                ->editColumn('checkin', function ($payment) {
                    return '<input type="checkbox" class="item-checkbox" data-id="' . $payment->id . '" data-isDraft="' . $payment->is_draft . '">';
                })
                ->editColumn('is_draft', function ($status) use ($approved, $draft) {
                    return $status->is_draft == 1 ? $draft : $approved;
                })
                ->editColumn('date', function ($date)  {
                    return Carbon::parse($date->date)->format('d M, y');
                })
                ->addColumn('actions', function ($payment) {
                    $action = '<button type="button"
                    data-date="' . $payment->date . '"
                    data-name="' . $payment->name . '"
                    data-site_name="' . $payment->site_name . '"
                    data-district="' . $payment->district . '"
                    data-area="' . $payment->area . '"
                    data-bank_name="' . $payment->site_bank_name . '"
                    data-account_no="' . $payment->site_account_no . '"
                    data-payment_method="' . $payment->payment_method . '"
                    data-net_payment_amount="' . $payment->net_payment_amount . '"
                    data-others_amount="' . $payment->others_amount . '"
                    data-total="' . $payment->total . '"
                    data-short_note="' . $payment->short_note . '"
                    class="btn btn-sm  btn-info text-white action-btn" style="margin-right:10px">' . VIEW_ICON . '</button>';
                        // $action .= status_change_modal($payment). '</div>';
                    return $action;
                })
                ->rawColumns(['checkin', 'actions', 'is_draft','date'])
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
            if (!Auth::user()->is_admin && !$payment->is_draft) {
                return redirect()->route('payment.list')->with('dismiss', __("Payment already approved"));
            }
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



    public function approved($id = null)
    {
        $payment = $this->paymentService->approved($id);
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
