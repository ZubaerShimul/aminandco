<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Services\PaymentService;
use App\Models\BankAccount;
use App\Models\Payment;
use App\Models\Tender;
use Illuminate\Http\Request;

class TenderPaymentController extends Controller
{
    private $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_expenses = Payment::query();

            return datatables($report_expenses)
                ->editColumn('date', function ($payment) {
                    return date('d M Y', strtotime($payment->date));
                })
                ->editColumn('account_id', function ($payment) {
                    return $payment->account ? $payment->account->name : '';
                })
                ->editColumn('tender_id', function ($payment) {
                    return $payment->tender ? $payment->tender->tender_no : '';
                })

                ->addColumn('actions', function ($payment) {
                    $action = '<a href="' . route('payment.edit', ['id' => $payment->id]) . '" class="btn btn-sm  btn-info text-white" style="margin-right:10px">' . EDIT_ICON . '</a>';
                    $action .= delete_modal($payment->id, 'payment.delete') . '</div>';

                    return $action;
                })
                ->rawColumns(['date', 'account_id', 'tender_id', 'actions'])
                ->make(TRUE);
        }
        return view('tender.payment.index');
    }

    public function create()
    {
        $accounts       = BankAccount::get();
        // $tenders        = Tender::where('end_date', '>', Carbon::now()->toDateString())->get();
        $tenders        = Tender::get();

        return view('tender.payment.create', ['accounts' => $accounts, 'tenders' => $tenders]);
    }

    public function store(PaymentRequest $request)
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
            $tenders        = Tender::get();

            return view('tender.payment.edit', ['payment' => $payment, 'tenders' => $tenders]);
        }
        return redirect()->route('payment.list')->with('dismiss', __("payment not found"));
    }

    public function update(PaymentRequest $request)
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
}
