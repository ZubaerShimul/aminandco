<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_employee = User::query();
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
        return view('user.index');
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(UserRequest $request)
    {
        $data = [
            "name"              => $request->name,
            "email"             => $request->email,
            "phone"             => $request->mobile_number,
            "designation"       => $request->designation,
            "address"           => $request->address,
            "enable_edit"       => $request->enable_edit == ENABLE ? ENABLE : DISABLE,
            "enable_delete"     => $request->enable_delete == ENABLE ? ENABLE : DISABLE,
            'password'          => Hash::make($request->password)
            // 'status'        => $request->status
        ];
        
        if(!empty($request->image)) {
            $data['image'] = fileUpload($request->image, DOCUMENT_PATH);
        }

        try {
            User::create($data);
            return redirect()->route('user.list')->with('success', __("Added successfully"));

    }catch(Exception $exception){
        return redirect()->back()->with('dismiss', $exception->getMessage());
    }
    }

    // edit

    public  function edit($id = null)
    {
        $employee = Employee::where('id', $id)->first();
        if($employee) {
            return view('user.edit',['data' => $employee]);
        }
        return redirect()->route('user.list')->with('dismiss', "Not found");
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
            return redirect()->route('user.list')->with('success', __("Updted successfully"));
        }
        return redirect()->route('user.list')->with('dismiss', "Not found");
    }


    // delete
    public  function delete($id = null)
    {
        $employee = Employee::where('id', $id)->first();
        if($employee) {
            $employee->delete();
            return redirect()->route('user.list')->with('success', __("deleted successfully"));
        }
        return redirect()->route('user.list')->with('dismiss', "Not found");
    }
    //details
    public function details($id)
    {
        $employee = Employee::find($id);

        if ($employee) {
            return response()->json([
                'designation' => $employee->designation,
                'salary' => $employee->basic_salary
            ]);
        }

        return response()->json(['error' => 'Employee not found'], 404);
    }

}
