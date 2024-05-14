<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_employee = Employee::query();
            return datatables($report_employee)
                ->editColumn('checkin', function ($employee) {
                    return '<input type="checkbox" class="item-checkbox" data-id="'.$employee->id.'">';
                })
                ->addColumn('actions', function ($employee) {
                    $action = '<button type="button"
                    data-name="'.$employee->name.'"
                    data-type="'.$employee->type.'"
                    data-mobile_number="'.$employee->mobile_number.'"
                     class="btn btn-sm  btn-info text-white action-btn" style="margin-right:10px">' . VIEW_ICON . '</button>';
                    // $action .= status_change_modal($employee). '</div>';
                    return $action;
                })
                ->rawColumns(['checkin', 'actions'])
                ->make(TRUE);
        }
        return view('employee.index');
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(EmployeeRequest $request)
    {
        $data = [
            'created_by'    => Auth::id(),
            "name"          => $request->name,
            "designation"   => $request->designation,
            "NID"           => $request->NID,
            "address"       => $request->address,
            "blood_group"   => $request->blood_group,
            "contact_no"    => $request->contact_no,
            "joining_date"  => $request->joining_date,
            "resigning_date" => $request->resigning_date,
            "basic_salary"  => $request->basic_salary
        ];
        if(!empty($request->image)) {
            $data['image'] = fileUpload($request->image, DOCUMENT_PATH);
        }

        try {
            Employee::create($data);
            return redirect()->route('employee.list')->with('success', __("Added successfully"));

    }catch(Exception $exception){
        return redirect()->back()->with('dismiss', $exception->getMessage());
    }
    }

    // edit

    public  function edit($id = null)
    {
        $employee = Employee::where('id', $id)->first();
        if($employee) {
            return view('employee.edit',['data' => $employee]);
        }
        return redirect()->route('employee.list')->with('dismiss', "Not found");
    }

    public function update(EmployeeRequest $request)
    {
        $employee = Employee::where('id', $request->id)->first();
        if($employee) {
            $data = [
                "name"          => $request->name,
                "designation"   => $request->designation,
                "NID"           => $request->NID,
                "address"       => $request->address,
                "blood_group"   => $request->blood_group,
                "contact_no"    => $request->contact_no,
                "joining_date"  => $request->joining_date,
                "resigning_date" => $request->resigning_date,
                "basic_salary"  => $request->basic_salary
            ];
            if(!empty($request->image)) {
                $data['image'] = fileUpload($request->image, DOCUMENT_PATH, $employee->image);
            }
            $employee->update($data);
            return redirect()->route('employee.list')->with('success', __("Updted successfully"));
        }
        return redirect()->route('employee.list')->with('dismiss', "Not found");
    }


    // delete
    public  function delete($id = null)
    {
        $employee = Employee::where('id', $id)->first();
        if($employee) {
            $employee->delete();
            return redirect()->route('employee.list')->with('success', __("deleted successfully"));
        }
        return redirect()->route('employee.list')->with('dismiss', "Not found");
    }


}
