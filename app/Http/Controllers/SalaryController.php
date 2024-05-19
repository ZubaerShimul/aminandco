<?php

namespace App\Http\Controllers;

use App\Http\Services\SalaryService;
use App\Models\BankAccount;
use App\Models\Employee;
use App\Models\PaymentMethod;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{

    private $salaryService;
    public function __construct(SalaryService $salaryService)
    {
        $this->salaryService = $salaryService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_salary = Salary::query();
            return datatables($report_salary)
                ->editColumn('checkin', function ($salary) {
                    return '<input type="checkbox" class="item-checkbox" data-id="' . $salary->id . '">';
                })
                ->addColumn('actions', function ($salary) {
                    $action = '<button type="button"
                    data-name="' . $salary->name . '"
                    data-type="' . $salary->type . '"
                    data-mobile_number="' . $salary->mobile_number . '"
                     class="btn btn-sm  btn-info text-white action-btn" style="margin-right:10px">' . VIEW_ICON . '</button>';
                    // $action .= status_change_modal($salary). '</div>';
                    return $action;
                })
                ->rawColumns(['checkin', 'actions'])
                ->make(TRUE);
        }
        return view('salary.index');
    }

    public function create()
    {
        $data['accounts']  = BankAccount::get();
        $data['employees'] = Employee::get();
        $data['payment_methods'] = PaymentMethod::get();

        return view('salary.create', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $salary = $this->salaryService->store($request);
        if ($salary['success'] == true) {
            return redirect()->route('salary.list')->with('success', $salary['message']);
        }
        return redirect()->back()->with('dismiss', $salary['message']);
    }

    public function edit($id = null)
    {
        $salary = Salary::where(['id' => $id])->with('account')->first();
        if (!empty($salary)) {
            $data['accounts']  = BankAccount::get();
            $data['employees'] = Employee::get();
            $data['payment_method'] = PaymentMethod::get();

            return view('salary.edit', ['salary' => $salary, 'data' => $data]);
        }
        return redirect()->route('salary.list')->with('dismiss', __("Salary not found"));
    }

    public function update(Request $request)
    {

        $salary = $this->salaryService->update($request);

        if ($salary['success'] == TRUE) {
            return redirect()->route('salary.list')->with('success', $salary['message']);
        }
        return redirect()->back()->with('dismiss', $salary['message']);
    }

    public function delete($id = null)
    {
        $salary = $this->salaryService->delete($id);
        if ($salary['success'] == true) {
            return redirect()->route('salary.list')->with('success', $salary['message']);
        }
        return redirect()->route('salary.list')->with('dismiss', $salary['message']);
    }

    // public function getLaboursByTender($tenderId)
    // {
    //     $labors = Labour::where('tender_id', $tenderId)->get();
    //     return response()->json($labors);
    // }
}
