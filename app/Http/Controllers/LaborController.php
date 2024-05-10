<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaborRequest;
use App\Http\Services\LabourService;
use App\Models\Labour;
use App\Models\Tender;
use Carbon\Carbon;
use Illuminate\Http\Request;

use PDF;

class LaborController extends Controller
{
    private $labourService;
    public function __construct(LabourService $labourService)
    {
        $this->labourService = $labourService;
    }
    public function index(Request $request)
    {
        $tenders = Tender::get();
        $tenderId = $request->input('tender_id');
        if ($request->ajax()) {

            $report_categories = Labour::select('*')->orderBy('id', 'desc');
            if (isset($tenderId)) {
                $report_categories = Labour::select('*')->orderBy('id', 'desc')->where('tender_id', $tenderId);
            }

            return datatables($report_categories)
                ->editColumn('joining_date', function ($labour) {
                    return date('d M Y', strtotime($labour->joining_date));
                })
                ->editColumn('tender_id', function ($tender) {
                    return $tender->tender ? $tender->tender->tender_no : '';
                })

                ->addColumn('actions', function ($labour) {
                    $action = '<a href="' . route('labour.edit', ['id' => $labour->id]) . '" class="btn btn-sm  btn-info text-white" style="margin-right:10px">' . EDIT_ICON . '</a>';
                    $action .= delete_modal($labour->id, 'labour.delete') . '</div>';

                    return $action;
                })
                ->rawColumns(['joining_date', 'tender_id', 'actions'])
                ->make(TRUE);
        }
        return view('labour.index', ['tenders' => $tenders]);
    }

    public function create()
    {
        // $tenders = Tender::where('end_date', '>', Carbon::now()->toDateString())->get();
        $tenders = Tender::get();
        return view('labour.create', ['tenders' => $tenders]);
    }

    public function store(LaborRequest $request)
    {
        $labour = $this->labourService->store($request);
        if ($labour['success'] == true) {
            return redirect()->route('labour.list')->with('success', $labour['message']);
        }
        return redirect()->back()->with('dismiss', $labour['message']);
    }

    public function edit($id = null)
    {
        $labour = Labour::where(['id' => $id])->first();
        $tenders = Tender::where('end_date', '>', Carbon::now()->toDateString())->get();

        if (!empty($labour)) {
            return view('labour.edit', ['labour' => $labour, 'tenders' => $tenders]);
        }
        return redirect()->route('labour.list')->with('dismiss', __("Labour not found"));
    }

    public function update(LaborRequest $request)
    {
        $manufacturer = $this->labourService->update($request);

        if ($manufacturer['success'] == TRUE) {
            return redirect()->route('labour.list')->with('success', $manufacturer['message']);
        }
        return redirect()->back()->with('dismiss', $manufacturer['message']);
    }

    public function delete($id = null)
    {
        $labour = $this->labourService->delete($id);
        if ($labour['success'] == true) {
            return redirect()->route('labour.list')->with('success', $labour['message']);
        }
        return redirect()->route('labour.list')->with('dismiss', $labour['message']);
    }
    // ************************ pdf******************

    public function showEmployees()
    {
        $employee = Labour::all();
        return view('employee', compact('employee'));
    }
}
