<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Http\Requests\BankAccountRequest;
use App\Models\BankAccount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_bank = BankAccount::query();
            return datatables($report_bank)
                ->editColumn('checkin', function ($bank) {
                    return '<input type="checkbox" class="item-checkbox" data-id="'.$bank->id.'">';
                })
                ->addColumn('actions', function ($bank) {
                    $action = '<button type="button"
                    data-name="'.$bank->name.'"
                    data-account_number="'.$bank->account_number.'"
                    data-branch="'.$bank->branch.'"
                    data-balance="'.$bank->balance.'"
                     class="btn btn-sm  btn-info text-white action-btn" style="margin-right:10px">' . VIEW_ICON . '</button>';
                    // $action .= status_change_modal($bank). '</div>';
                    return $action;
                })
                ->rawColumns(['checkin', 'actions'])
                ->make(TRUE);
        }
        return view('category.bank_account.index');
    }

    public function storeUpdate(BankAccountRequest $request)
    {
        $bank = null;
        if(!empty($request->id)) {
            $bank = BankAccount::where(['id' => $request->id])->first();
            if(empty($bank)) {
                return redirect()->route('bank_account.list')->with('dismiss', __("Not Found"));
            }
        }
        $data = [
            'created_by'       => !empty($bank) ? $bank->created_by : Auth::user()->id,
            'name'             => $request->name,
            'account_number'   => $request->account_number,
            'branch'            => $request->branch,
        ];
        try {

            // update record
            if(!empty($bank)) {
                $bank->update($data);
                return redirect()->route('bank_account.list')->with('success', __("Updated successfully"));
            }

            // create new record
            BankAccount::create($data);
            return redirect()->route('bank_account.list')->with('success', __("Added successfully"));

    }catch(Exception $exception){
        return redirect()->route('bank_account.list')->with('dismiss', $exception->getMessage());
    }
    }

    // edit

    public  function edit($id = null)
    {
        $bank = BankAccount::where('id', $id)->first();
        if($bank) {
            return view('category.bank_account.index',['data' => $bank]);
        }
        return redirect()->route('bank_account.list')->with('dismiss', "Not found");
    }


    // delete
    public  function delete($id = null)
    {
        $bank = BankAccount::where('id', $id)->first();
        if($bank) {
            $bank->delete();
            return redirect()->route('bank_account.list')->with('success', __("deleted successfully"));
        }
        return redirect()->route('bank_account.list')->with('dismiss', "Not found");
    }
    
    //details
    public function details($id)
    {

        $account = explode('-', $id);
        return response()->json([
            'name' => isset($account) ? $account[1] : '',
            'account_no' => isset($account) ? $account[2] : ''
        ]);
    }

}
