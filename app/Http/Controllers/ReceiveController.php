<?php

namespace App\Http\Controllers;

use App\Http\Services\ReceivService;
use App\Models\BankAccount;
use App\Models\PaymentMethod;
use App\Models\Receive;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiveController extends Controller
{
    private $receiveService;
    public function __construct(ReceivService $receiveService)
    {
        $this->receiveService = $receiveService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_payment = Receive::query();

            $approved = '<span class="badge bg-success">' . __('Yes') . '</span>';
            $draft = '<span class="badge bg-danger">' . __('No') . '</span>';

            return datatables($report_payment)
                ->editColumn('checkin', function ($receive) {
                    return '<input type="checkbox" class="item-checkbox" data-id="' . $receive->id . '" data-isDraft="' . $receive->is_draft . '">';
                })
                ->editColumn('date', function ($date) {
                    return date('d M, Y', strtotime($date->date));
                })
                ->editColumn('is_draft', function ($status) use ($approved, $draft) {
                    return $status->is_draft == 1 ? $draft : $approved;
                })
                ->addColumn('actions', function ($receive) {
                    $action = '<button type="button"
                    data-id="' . $receive->id . '"
                    data-date="' . $receive->date . '"
                    data-name="' . $receive->name . '"
                    data-district="' . $receive->district . '"
                    data-area="' . $receive->area . '"
                    data-bank_name="' . $receive->bank_name . '"
                    data-account_no="' . $receive->account_no . '"
                    data-payment_method="' . $receive->payment_method . '"
                    data-net_payment_amount="' . $receive->net_payment_amount . '"
                    data-others_amount="' . $receive->others_amount . '"
                    data-total="' . $receive->total . '"
                    data-short_note="' . $receive->short_note . '"
                     class="btn btn-sm  btn-info text-white action-btn" style="margin-right:10px">' . VIEW_ICON . '</button>';
                     if($receive->document!=null){
                        $action.='<button type="button"
                        data-doc="' . $receive->document . '"
                        class="btn btn-sm  btn-success text-white doc-btn" style="margin-top:1px">' . VIEW_DOC . '</button>';
                     }
                    // $action .= status_change_modal($receive). '</div>';
                    return $action;
                })
                ->rawColumns(['checkin', 'actions', 'is_draft', 'date'])
                ->make(TRUE);
        }
        return view('receive.index');
    }

    public function create()
    {
        $data['accounts']           = BankAccount::orderBy('name', 'asc')->get();
        $data['payment_methods']    = PaymentMethod::orderBy('name', 'asc')->get();
        $data['sites']              = Site::where('name', '!=', null)->orderBy('id', 'desc')->get();
        $data['districts']          = Site::where('division', '!=', '')->get()->unique('division');
        $data['areas']              = Site::where('area', '!=', null)->get()->unique('area');

        return view('receive.create', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $receive = $this->receiveService->store($request);
        if ($receive['success'] == true) {
            return redirect()->route('receive.list')->with('success', $receive['message']);
        }
        return redirect()->back()->with('dismiss', $receive['message']);
    }

    public function edit($id = null)
    {
        $receive = Receive::where(['id' => $id])->with('account')->first();
        if (!empty($receive)) {
            if (!Auth::user()->is_admin && !$receive->is_draft) {
                return redirect()->route('receive.list')->with('dismiss', __("Receive already approved"));
            }
            $data['accounts']           = BankAccount::orderBy('name', 'asc')->get();
            $data['payment_methods']    = PaymentMethod::orderBy('name', 'asc')->get();
            $data['sites']              = Site::where('name', '!=', null)->orderBy('id', 'desc')->get();

            $data['districts']          = Site::where('division', '!=', '')->get()->unique('division');
            $data['areas']              = Site::where('area', '!=', null)->get()->unique('area');
            return view('receive.edit', ['receive' => $receive, 'data' => $data]);
        }
        return redirect()->route('receive.list')->with('dismiss', __("receive. not found"));
    }

    public function update(Request $request)
    {

        $receive = $this->receiveService->update($request);

        if ($receive['success'] == TRUE) {
            return redirect()->route('receive.list')->with('success', $receive['message']);
        }
        return redirect()->back()->with('dismiss', $receive['message']);
    }

    public function delete($id = null)
    {
        $receive = $this->receiveService->delete($id);
        if ($receive['success'] == true) {
            return redirect()->route('receive.list')->with('success', $receive['message']);
        }
        return redirect()->route('receive.list')->with('dismiss', $receive['message']);
    }


    public function approved($id = null)
    {
        $receive = $this->receiveService->approved($id);
        if ($receive['success'] == true) {
            return redirect()->route('receive.list')->with('success', $receive['message']);
        }
        return redirect()->route('receive.list')->with('dismiss', $receive['message']);
    }

    public function print($id){
        $details=Receive::where(['id' => $id])->with('account')->first();
        // dd($details->name);
        return view('receive.print',['details' => $details]);
    }
}
