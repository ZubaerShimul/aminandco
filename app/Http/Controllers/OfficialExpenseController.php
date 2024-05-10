<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseOfficialRequest;
use App\Http\Services\ExpenseService;
use App\Models\BankAccount;
use App\Models\ExpenseIncome;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfficialExpenseController extends Controller
{
    private $expenseService;
    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_expenses = ExpenseIncome::where(['is_official' => ENABLE, 'type' => EXPENSE]);

            return datatables($report_expenses)
                ->editColumn('date', function ($expense) {
                    return date('d M Y', strtotime($expense->date));
                })
                ->editColumn('account_id', function ($expense) {
                    return $expense->account ? $expense->account->name : '';
                })

                ->addColumn('actions', function ($expense) {
                    $action = '<a href="' . route('expense.official.edit', ['id' => $expense->id]) . '" class="btn btn-sm  btn-info text-white" style="margin-right:10px">' . EDIT_ICON . '</a>';
                    $action .= delete_modal($expense->id, 'expense.official.delete') . '</div>';

                    return $action;
                })
                ->rawColumns(['date', 'account_id', 'type', 'actions'])
                ->make(TRUE);
        }
        return view('expense.official.index');
    }

    public function create()
    {
        $accounts = BankAccount::get();
        return view('expense.official.create', ['accounts' => $accounts]);
    }

    public function store(ExpenseOfficialRequest $request)
    {
        // bank account update start
        $bankAccount = BankAccount::where(['id' =>  $request->get('account')])->first();
        if (empty($bankAccount)) {
            return redirect()->back()->with('dismiss', __("Account not found"));
        }
        // if($bankAccount->balance < $request->total_amount) {
        //     return errorResponse("No available balance");
        // }

        $data = [
            'user_id'           => 1,
            'account_id'        => $bankAccount->id,
            'payment_method'    => $request->payment_method,
            'total_amount'      => $request->total_amount,
            'date'              => $request->date ? $request->date : Carbon::now()->toDateString(),
            'category_id'       => CATEGORY_ID_OFFICIAL_EXPENSE,
            'type'              => EXPENSE,
            'description'       => $request->description,
            'adjustment'        => 0,
            'grand_total'       => $request->total_amount,
            'is_official'       => ENABLE
        ];
        $expense = $this->expenseService->store($bankAccount, $data);
        if ($expense['success'] == true) {
            return redirect()->route('expense.official.list')->with('success', $expense['message']);
        }
        return redirect()->back()->with('dismiss', $expense['message']);
    }

    public function edit($id = null)
    {
        $expense = ExpenseIncome::where(['id' => $id])->with('account')->first();
        if (!empty($expense)) {
            return view('expense.official.edit', ['expense' => $expense]);
        }
        return redirect()->route('expense.official.list')->with('dismiss', __("expense not found"));
    }

    public function update(ExpenseOfficialRequest $request)
    {
        $expense = ExpenseIncome::where(['id' => $request->edit_id])->first();
        if (empty($expense)) {
            return redirect()->back()->with('dismiss', __("Expense not found"));
        }

        // bank account update start
        $bankAccount = BankAccount::where(['id' =>  $request->get('account')])->first();
        if (empty($bankAccount)) {
            return redirect()->back()->with('dismiss', __("Account not found"));
        }

        // if (($bankAccount->balance + $expense->grand_total) < $request->total_amount) {
        //     return errorResponse("No available balance");
        // }

        $data = [
            'user_id'           => 1,
            // 'account_id'        => $bankAccount->id,
            'payment_method'    => $request->payment_method,
            'total_amount'      => $request->total_amount,
            'date'              => $request->date ? $request->date : Carbon::now()->toDateString(),
            'description'       => $request->description,
            'grand_total'       => $request->total_amount,
        ];

        $manufacturer = $this->expenseService->update($expense, $bankAccount, $data);

        if ($manufacturer['success'] == TRUE) {
            return redirect()->route('expense.official.list')->with('success', $manufacturer['message']);
        }
        return redirect()->back()->with('dismiss', $manufacturer['message']);
    }

    public function delete($id = null)
    {
        $expense = $this->expenseService->delete($id);
        if ($expense['success'] == true) {
            return redirect()->route('expense.official.list')->with('success', $expense['message']);
        }
        return redirect()->route('expense.official.list')->with('dismiss', $expense['message']);
    }
}
