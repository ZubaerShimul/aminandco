<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\Models\PaymentMethod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_Payment_method = PaymentMethod::query();
            return datatables($report_Payment_method)
                ->editColumn('checkin', function ($payment_method) {
                    return '<input type="checkbox" class="item-checkbox" data-id="'.$payment_method->id.'">';
                })
                ->addColumn('actions', function ($payment_method) {
                    $action = '<button type="button"
                    data-name="'.$payment_method->name.'"
                    data-account_number="'.$payment_method->account_number.'"
                    data-branch="'.$payment_method->branch.'"
                    data-balance="'.$payment_method->balance.'"
                     class="btn btn-sm  btn-info text-white action-btn" style="margin-right:10px">' . VIEW_ICON . '</button>';
                    // $action .= status_change_modal($payment_method). '</div>';
                    return $action;
                })
                ->rawColumns(['checkin', 'actions'])
                ->make(TRUE);
        }
        return view('category.payment_method.index');
    }

    public function storeUpdate(PaymentMethodRequest $request)
    {
        $payment_method = null;
        if(!empty($request->id)) {
            $payment_method = PaymentMethod::where(['id' => $request->id])->first();
            if(empty($payment_method)) {
                return redirect()->route('payment_method.list')->with('dismiss', __("Not Found"));
            }
        }
        $data = [
            'created_by'       => !empty($payment_method) ? $payment_method->created_by : Auth::user()->id,
            'name'             => $request->name,
        ];
        
        try {

            // update record
            if(!empty($payment_method)) {
                $payment_method->update($data);
                return redirect()->route('payment_method.list')->with('success', __("Updated successfully"));
            }

            // create new record
            PaymentMethod::create($data);
            return redirect()->route('payment_method.list')->with('success', __("Added successfully"));

    }catch(Exception $exception){
        return redirect()->route('payment_method.list')->with('dismiss', $exception->getMessage());
    }
    }

    // edit

    public  function edit($id = null)
    {
        $payment_method = PaymentMethod::where('id', $id)->first();
        if($payment_method) {
            return view('category.payment_method.index',['data' => $payment_method]);
        }
        return redirect()->route('payment_method.list')->with('dismiss', "Not found");
    }


    // delete
    public  function delete($id = null)
    {
        $payment_method = PaymentMethod::where('id', $id)->first();
        if($payment_method) {
            $payment_method->delete();
            return redirect()->route('payment_method.list')->with('success', __("deleted successfully"));
        }
        return redirect()->route('payment_method.list')->with('dismiss', "Not found");
    }


}
