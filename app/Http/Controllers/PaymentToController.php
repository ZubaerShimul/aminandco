<?php

namespace App\Http\Controllers;

use App\Models\PaymentTo;
use Exception;
use Illuminate\Http\Request;

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
                    $action = '<a href="' . route('payment.to.edit', ['id' => $paymentTo->id]) . '" class="btn btn-sm  btn-info text-white" style="margin-right:10px">' . VIEW_ICON . '</a>';
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
        try {

            PaymentTo::create([
                'name' => $request->name,
                'type' => $request->type,
                'mobile_number' => $request->mobile_number,
            ]);
            return redirect()->route('payment.to.list')->with('success', __("Added successfully"));

    }catch(Exception $exception){
        return redirect()->back()->with('dismiss', $exception->getMessage());
    }
    }
}
