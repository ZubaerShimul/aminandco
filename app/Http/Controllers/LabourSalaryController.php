<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabourSalaryRequest;
use App\Http\Services\SalaryService;
use App\Models\BankAccount;
use App\Models\Category;
use App\Models\Labour;
use App\Models\LabourSalary;
use App\Models\Tender;
use Illuminate\Http\Request;

class LabourSalaryController extends Controller
{
    private $salaryService;
    public function __construct(SalaryService $salaryService)
    {
        $this->salaryService = $salaryService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_expenses = LabourSalary::query();

            return datatables($report_expenses)
                ->editColumn('date', function ($salary) {
                    return date('d M Y', strtotime($salary->date));
                })
                ->editColumn('account_id', function ($salary) {
                    return $salary->account ? $salary->account->name : '';
                })
                ->editColumn('tender_id', function ($salary) {
                    return $salary->tender ? $salary->tender->tender_no : '';
                })->editColumn('labour_id', function ($salary) {
                    return $salary->labour ? $salary->labour->name : '';
                })

                ->addColumn('actions', function ($salary) {
                    $action = '<a href="' . route('salary.edit', ['id' => $salary->id]) . '" class="btn btn-sm  btn-info text-white" style="margin-right:10px">' . EDIT_ICON . '</a>';
                    $action .= delete_modal($salary->id, 'salary.delete') . '</div>';

                    return $action;
                })
                ->rawColumns(['date', 'account_id', 'tender_id', 'labour_id', 'type', 'actions'])
                ->make(TRUE);
        }
        return view('labour.salary.index');
    }

    public function cartList(Request $request)
    {
        if ($request->ajax()) {

            $labours = Labour::where(['tender_id' => $request->id])->get();
            response()->json($labours);

            return view('labour.salary.labourlist', ['labours' => $labours]);
        }
    }

    public function create()
    {
        $accounts       = BankAccount::get();
        // $tenders        = Tender::where('end_date', '>', Carbon::now()->toDateString())->get();
        $tenders        = Tender::get();
        $labours = Labour::get();

        return view('labour.salary.create', ['accounts' => $accounts, 'tenders' => $tenders, 'labours' => $labours]);
    }

    public function store(LabourSalaryRequest $request)
    {
        $salary = $this->salaryService->store($request);
        if ($salary['success'] == true) {
            return redirect()->route('salary.list')->with('success', $salary['message']);
        }
        return redirect()->back()->with('dismiss', $salary['message']);
    }

    public function edit($id = null)
    {
        $salary = LabourSalary::where(['id' => $id])->with('account')->first();
        if (!empty($salary)) {
            $tenders        = Tender::get();
            $labours = Labour::get();

            return view('labour.salary.edit', ['salary' => $salary, 'tenders' => $tenders, 'labours' => $labours]);
        }
        return redirect()->route('salary.list')->with('dismiss', __("Salary not found"));
    }

    public function update(LabourSalaryRequest $request)
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

    public function getLaboursByTender($tenderId)
    {
        $labors = Labour::where('tender_id', $tenderId)->get();
        return response()->json($labors);
    }
}
