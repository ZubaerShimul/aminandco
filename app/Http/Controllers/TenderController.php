<?php

namespace App\Http\Controllers;

use App\Http\Requests\TenderRequest;
use App\Http\Services\TenderService;
use App\Models\BankAccount;
use App\Models\District;
use App\Models\ExpenseIncome;
use App\Models\LabourSalary;
use App\Models\Payment;
use App\Models\Tender;
use Exception;
use Illuminate\Http\Request;
use PDF;


class TenderController extends Controller
{

    private $tenderService;
    public function __construct(TenderService $tenderService)
    {
        $this->tenderService = $tenderService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_tenders = Tender::query();
            $yes = '<span class="badge bg-success">' . __('Yes') . '</span>';
            $no = '<span class="badge bg-danger">' . __('No') . '</span>';
            return datatables($report_tenders)
                ->editColumn('paid', function ($tender) {
                    return Payment::where(['tender_id' => $tender->id])->sum('grand_total');
                })
                ->editColumn('expense', function ($tender) {
                    return ExpenseIncome::where(['tender_id' => $tender->id, 'type' => CATEGORY_TYPE_EXPENSE])->sum('grand_total');
                })
                ->editColumn('payment_status', function ($tender) use ($yes, $no) {
                    if($tender->budget > 0) {
                        $payments = Payment::where(['tender_id' => $tender->id])->sum('grand_total');
                        if ($payments > 0 && $payments < $tender->budget) {
                            $payment_status = '<span class="badge bg-primary">' . __('Partial') . '</span>';
                        } elseif ( $payments >= $tender->budget) {
                            $payment_status = '<span class="badge bg-success">' . __('Paid') . '</span>';
                        } else {
                            $payment_status = '<span class="badge bg-danger">' . __('Unpaid') . '</span>';
                        }
                    } else {
                        $payment_status = '<span class="badge bg-secondary">' . __('No Budget') . '</span>';

                    }
                    
                    return $payment_status;
                })

                ->editColumn('account_id', function ($tender) {
                    return $tender->account ?  $tender->account->name : '';
                })

                ->editColumn('created_at', function ($tender) {
                    return date('d M Y', strtotime($tender->created_at));
                })
                // ->editColumn('status', function ($tender){
                //     return tender_status_html($tender->status);
                // })
                ->addColumn('actions', function ($tender) {
                    $action = '<div class="d-flex justify-content-center"><a href="' . route('tender.details', ['id' => $tender->id]) . '" class="btn btn-sm btn-primary text-white" style="margin-right:10px">' . VIEW_ICON . '</a>';
                    $action .= '<a href="' . route('tender.edit', ['id' => $tender->id]) . '" class="btn btn-sm  btn-info text-white" style="margin-right:10px">' . EDIT_ICON . '</a>';
                    $action .= delete_modal($tender->id, 'tender.delete');

                    $action .= '<a href="' . route('tender.invoice.create', ['id' => $tender->id]) . '" class="btn btn-sm btn-success text-white" style="margin-right:10px">' . INVOICE_ICON . '</a>';
                    // $action .= status_change_modal($tender). '</div>';
                    return $action;
                })
                ->rawColumns(['paid','expense','account_id', 'created_at', 'status', 'payment_status', 'actions'])
                ->make(TRUE);
        }
        return view('tender.index');
    }

    public function create()
    {
        $districts = District::all();
        $accounts = BankAccount::all();
        return view('tender.create', ['districts' => $districts, 'accounts' => $accounts]);
    }
    public function store(TenderRequest $request)
    {

        // dd($request->all());
        $tender = $this->tenderService->store($request);
        if ($tender['success'] == true) {
            return redirect()->route('tender.list')->with('success', $tender['message']);
        }
        return redirect()->back()->with('dismiss', $tender['message']);
    }

    public function edit($id = null)
    {
        $tender = tender::where(['id' => $id])->first();
        if (!empty($tender)) {

            $districts = District::all();
            $accounts = BankAccount::all();
            return view('tender.edit', ['tender' => $tender, 'districts' => $districts, 'accounts' => $accounts]);
        }
        return redirect()->route('tender.list')->with('dismiss', __("tender not found"));
    }

    public function update(TenderRequest $request)
    {
        $manufacturer = $this->tenderService->update($request);

        if ($manufacturer['success'] == TRUE) {
            return redirect()->route('tender.list')->with('success', $manufacturer['message']);
        }
        return redirect()->back()->with('dismiss', $manufacturer['message']);
    }

    public function delete($id = null)
    {
        $tender = $this->tenderService->delete($id);
        if ($tender['success'] == true) {
            return redirect()->route('tender.list')->with('success', $tender['message']);
        }
        return redirect()->route('tender.list')->with('dismiss', $tender['message']);
    }

    public function details($id = null)
    {
        $tender = Tender::where(['id' => $id])->first();
        if (!empty($tender)) {
            $payment = Payment::where(['tender_id' => $tender->id])->sum('grand_total');
            $expense = ExpenseIncome::where(['tender_id' => $tender->id, 'type' => CATEGORY_TYPE_EXPENSE])->sum('grand_total');
            $tender_expenses = ExpenseIncome::where(['tender_id' => $tender->id, 'type' => CATEGORY_TYPE_EXPENSE,  'is_tender' => ENABLE])->get();
            $labour_expenses = LabourSalary::where(['tender_id' => $tender->id])->get();


            $tender_incomes = ExpenseIncome::where(['tender_id' => $tender->id, 'type' => CATEGORY_TYPE_INCOME,  'is_tender' => ENABLE])->get();
            $payments = Payment::where(['tender_id' => $tender->id])->get();

            $data = [
                'payment' => $payment,
                'expense' => $expense,
                'tender_expenses' => $tender_expenses,
                'labour_expenses' => $labour_expenses,
                'tender_incomes' => $tender_incomes,
                'payments' => $payments,
            ];
            return view('tender.details', ['tender' => $tender, 'data' => $data]);
        }
        return redirect()->back()->with('dismiss', __("Tender not found"));
    }




    public function invoice($id = null)
    {
        $tender = Tender::where(['id' => $id])->first();
        if (!empty($tender)) {
            $payment = Payment::where(['tender_id' => $tender->id])->sum('grand_total');
            $expense = ExpenseIncome::where(['tender_id' => $tender->id, 'type' => CATEGORY_TYPE_EXPENSE])->sum('grand_total');
            $tender_expenses = ExpenseIncome::where(['tender_id' => $tender->id, 'type' => CATEGORY_TYPE_EXPENSE,  'is_tender' => ENABLE])->get();
            $labour_expenses = LabourSalary::where(['tender_id' => $tender->id])->get();


            $tender_incomes = ExpenseIncome::where(['tender_id' => $tender->id, 'type' => CATEGORY_TYPE_INCOME,  'is_tender' => ENABLE])->get();
            $payments = Payment::where(['tender_id' => $tender->id])->get();

            $data = [
                'tender'  => $tender,
                'payment' => $payment,
                'expense' => $expense,
                'tender_expenses' => $tender_expenses,
                'labour_expenses' => $labour_expenses,
                'tender_incomes' => $tender_incomes,
                'payments' => $payments,
            ];

            return view('tender.invoice2', ['tender' => $tender, 'data' => $data]);
        }
        // $pdf = PDF::loadView('tender.invoice2', $data);
        // return $pdf->download('tender.pdf');
        return redirect()->back()->with('dismiss', __("Tender not found"));
    }
}
