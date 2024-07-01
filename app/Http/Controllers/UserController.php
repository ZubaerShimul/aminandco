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
            $report_user = User::where('is_admin', DISABLE);
            return datatables($report_user)
                ->editColumn('checkin', function ($user) {
                    return '<input type="checkbox" class="item-checkbox" data-id="' . $user->id . '">';
                })
                ->addColumn('actions', function ($user) {
                    $action = '<button type="button"
                    data-name="' . $user->name . '"
                    data-type="' . $user->type . '"
                    data-mobile_number="' . $user->mobile_number . '"
                     class="btn btn-sm  btn-info text-white action-btn" style="margin-right:10px">' . VIEW_ICON . '</button>';
                    // $action .= status_change_modal($user). '</div>';
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
            "enable_edit"       => $request->has("edit") && $request->edit == "on" ? ENABLE : DISABLE,
            "enable_delete"     => $request->has("delete") && $request->delete == "on" ? ENABLE : DISABLE,
            'password'          => Hash::make($request->password)
            // 'status'        => $request->status
        ];
        if (!empty($request->image)) {
            $data['image'] = fileUpload($request->image, DOCUMENT_PATH);
        }
        try {
            User::create($data);
            return redirect()->route('user.list')->with('success', __("Added successfully"));
        } catch (Exception $exception) {
            return redirect()->back()->with('dismiss', $exception->getMessage());
        }
    }

    // edit

    public  function edit($id = null)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            return view('user.edit', ['data' => $user]);
        }
        return redirect()->route('user.list')->with('dismiss', "Not found");
    }

    public function update(UserRequest $request)
    {
        $user = User::where('id', $request->id)->first();
        if ($user) {
            $data = [
                "name"              => $request->name,
                "email"             => $request->email,
                "phone"             => $request->mobile_number,
                "designation"       => $request->designation,
                "address"           => $request->address,
                "enable_edit"       => $request->has("edit") && $request->edit == "on" ? ENABLE : DISABLE,
                "enable_delete"     => $request->has("delete") && $request->delete == "on" ? ENABLE : DISABLE,
                // 'status'        => $request->status
            ];
            if (!empty($request->image)) {
                $data['image'] = fileUpload($request->image, DOCUMENT_PATH, $user->image);
            }

            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }
            $user->update($data);
            return redirect()->route('user.list')->with('success', __("Updted successfully"));
        }
        return redirect()->route('user.list')->with('dismiss', "Not found");
    }


    // delete
    public  function delete($id = null)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->delete();
            return redirect()->route('user.list')->with('success', __("Deleted successfully"));
        }
        return redirect()->route('user.list')->with('dismiss', "Not found");
    }
}
