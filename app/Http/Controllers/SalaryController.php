<?php

namespace App\Http\Controllers;

use App\Http\Services\SalaryService;
use App\Models\BankAccount;
use App\Models\Employee;
use App\Models\PaymentMethod;
use App\Models\Salary;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            
            if($request->from_date && $request->to_date){
                $report_salary = Salary::query()->whereBetween('date', [Carbon::parse($request->from_date)->format('Y-m-d') . " 00:00:00", Carbon::parse($request->to_date)->format('Y-m-d') . " 23:59:59"]);
            }else{
                $report_salary = Salary::query();
            }
            // dd($report_salary);
            return datatables($report_salary)
                ->editColumn('checkin', function ($salary) {
                    return '<input type="checkbox" class="item-checkbox" data-id="' . $salary->id . '">';
                })
                ->addColumn('actions', function ($salary) {
                    $action = '<button type="button"
                    data-date="' . $salary->date . '"
                    data-name="' . $salary->name . '"
                    data-designation="' . $salary->designation . '"
                    data-bank_name="' . $salary->bank_name  . '"
                    data-payment_method="' . $salary->payment_method  . '"
                    data-salary="' . $salary->salary  . '"
                    data-ta_da="' . $salary->ta_da  . '"
                    data-mobile_bill="' . $salary->mobile_bill  . '"
                    data-total="' . $salary->total  . '"
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
