<?php

namespace App\Http\Controllers;

use App\Models\PaymentTo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentToController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_paymentTo = PaymentTo::query();
            return datatables($report_paymentTo)
                ->editColumn('checkin', function ($paymentTo) {
                    return '<input type="checkbox" class="item-checkbox" data-id="'.$paymentTo->id.'">';
                })
                ->editColumn('created_at', function ($paymentTo) {
                    return date('d M Y', strtotime($paymentTo->created_at));
                })
                ->addColumn('actions', function ($paymentTo) {
                    $action = '<button type="button"
                    data-name="'.$paymentTo->name.'"
                    data-type="'.$paymentTo->type.'"
                    data-mobile_number="'.$paymentTo->mobile_number.'"
                     class="btn btn-sm  btn-info text-white action-btn" style="margin-right:10px">' . VIEW_ICON . '</button>';
                    // $action .= status_change_modal($paymentTo). '</div>';
                    return $action;
                })
                ->rawColumns(['checkin','paid','expense','account_id', 'created_at', 'status', 'payment_status', 'actions'])
                ->make(TRUE);
        }
        return view('category.payment_to.index');
    }

    public function create()
    {
        return view('category.payment_to.create');
    }

    public function store(Request $request)
    {
        $mobile_number = exists(new PaymentTo(), [ 'mobile_number' => parse_contact($request->mobile_number)]);
        if($mobile_number) {
            return redirect()->back()->with('dismiss', "Mobile Number already added");
        }
        try {

            PaymentTo::create([
                'created_by'   => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'mobile_number' => parse_contact($request->mobile_number),
            ]);
            return redirect()->route('payment_to.list')->with('success', __("Added successfully"));

    }catch(Exception $exception){
        return redirect()->back()->with('dismiss', $exception->getMessage());
    }
    }

    // edit

    public  function edit($id = null)
    {
        $paymentTo = PaymentTo::where('id', $id)->first();
        if($paymentTo) {
            return view('category.payment_to.index',['data' => $paymentTo]);
        }
        return redirect()->route('payment_to.list')->with('dismiss', "Not found");
    }

    public function update(Request $request)
    {
        $mobile_number = exists(new PaymentTo(), [ 'mobile_number' => parse_contact($request->mobile_number)], $request->id);
        if($mobile_number) {
            return redirect()->back()->with('dismiss', "Mobile Number already added");
        }

        $paymentTo = PaymentTo::where('id', $request->id)->first();
        if($paymentTo) {
            $paymentTo->update([
                'name' => $request->name,
                'type' => $request->type,
                'mobile_number' => parse_contact($request->mobile_number),
            ]);
            return redirect()->route('payment_to.list')->with('success', __("Updted successfully"));
        }
        return redirect()->route('payment_to.list')->with('dismiss', "Not found");
    }


    // delete
    public  function delete($id = null)
    {
        $paymentTo = PaymentTo::where('id', $id)->first();
        if($paymentTo) {
            $paymentTo->delete();
            return redirect()->route('payment_to.list')->with('success', __("deleted successfully"));
        }
        return redirect()->route('payment_to.list')->with('dismiss', "Not found");
    }

}
