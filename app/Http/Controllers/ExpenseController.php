<?php

namespace App\Http\Controllers;

use App\Http\Services\ExpenseService;
use App\Models\BankAccount;
use App\Models\Expense;
use App\Models\PaymentMethod;
use App\Models\Site;
use Illuminate\Http\Request;

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

            return datatables($report_expenses)
                ->editColumn('date', function ($expense) {
                    return date('d M Y', strtotime($expense->date));
                })
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
}
