<?php

namespace App\Http\Controllers;

use App\Http\Services\ExpenseService;
use App\Models\BankAccount;
use App\Models\Expense;
use App\Models\PaymentMethod;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    private $expenseService;
    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_expenses = Expense::query();
            $approved = '<span class="badge bg-success">' . __('Yes') . '</span>';
            $draft = '<span class="badge bg-danger">' . __('No') . '</span>';

            return datatables($report_expenses)
                ->editColumn('checkin', function ($payment) {
                    return '<input type="checkbox" class="item-checkbox" data-id="' . $payment->id . '" data-isDraft="' . $payment->is_draft . '">';
                })
                ->editColumn('is_draft', function ($status) use ($approved, $draft) {
                    return $status->is_draft == 1 ? $draft : $approved;
                })
                ->editColumn('date', function ($date)  {
                    return date('d M, Y', strtotime($date->date));
                })
                ->addColumn('actions', function ($payment) {
                // ->addColumn('actions', function ($payment) {
                //     $action = '<button type="button"
                //     data-date="' . $payment->date . '"
                //     data-name="' . $payment->name . '"
                //     data-site_name="' . $payment->site_name . '"
                //     data-district="' . $payment->district . '"
                //     data-area="' . $payment->area . '"
                //     data-bank_name="' . $payment->site_bank_name . '"
                //     data-account_no="' . $payment->site_account_no . '"
                //     data-payment_method="' . $payment->payment_method . '"
                //     data-net_payment_amount="' . $payment->net_payment_amount . '"
                //     data-others_amount="' . $payment->others_amount . '"
                //     data-total="' . $payment->total . '"
                //     data-short_note="' . $payment->short_note . '"
                //     class="btn btn-sm  btn-info text-white action-btn" style="margin-right:10px">' . VIEW_ICON . '</button>';
                //         // $action .= status_change_modal($payment). '</div>';
                //     return $action;
                // })
                if($payment->document!=null){
                    $action='<button type="button"
                    data-doc="' . $payment->document . '"
                    class="btn btn-sm  btn-success text-white doc-btn" style="margin-top:1px">' . VIEW_DOC . '</button>';
                 }
                    // $action .= status_change_modal($payment). '</div>';
                return $action;
                })
                ->rawColumns(['checkin', 'actions', 'is_draft','date'])
                ->make(TRUE);
        }
        return view('expense.index');
    }

    public function create()
    {
        $data['accounts'] = BankAccount::orderBy('name', 'asc')->get();
        $data['payment_methods'] = PaymentMethod::orderBy('name', 'asc')->get();
        $data['sites'] = Site::orderBy('id', 'desc')->get();

        return view('expense.create', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $expense = $this->expenseService->store($request);
        if ($expense['success'] == true) {
            return redirect()->route('expense.list')->with('success', $expense['message']);
        }
        return redirect()->back()->with('dismiss', $expense['message']);
    }

    public function edit($id = null)
    {
        $expense = Expense::where(['id' => $id])->with('account')->first();
        if (!empty($expense)) {
            if (!Auth::user()->is_admin && !$expense->is_draft) {
                return redirect()->route('expense.list')->with('dismiss', __("Expense already approved"));
            }
            $data['accounts'] = BankAccount::orderBy('name', 'asc')->get();
            $data['payment_methods'] = PaymentMethod::orderBy('name', 'asc')->get();
            $data['sites'] = Site::orderBy('id', 'desc')->get();

            return view('expense.edit', ['expense' => $expense, 'data' =>  $data]);
        }
        return redirect()->route('expense.list')->with('dismiss', __("expense not found"));
    }

    public function update(Request $request)
    {
        $expense = $this->expenseService->update($request);
        if ($expense['success'] == true) {
            return redirect()->route('expense.list')->with('success', $expense['message']);
        }
        return redirect()->back()->with('dismiss', $expense['message']);
    }

    public function delete($id = null)
    {
        $expense = $this->expenseService->delete($id);
        if ($expense['success'] == true) {
            return redirect()->route('expense.list')->with('success', $expense['message']);
        }
        return redirect()->route('expense.list')->with('dismiss', $expense['message']);
    }

    
    public function approved($id = null)
    {
        $receive = $this->expenseService->approved($id);
        if ($receive['success'] == true) {
            return redirect()->route('expense.list')->with('success', $receive['message']);
        }
        return redirect()->route('expense.list')->with('dismiss', $receive['message']);
    }
}
