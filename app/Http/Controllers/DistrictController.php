<?php

namespace App\Http\Controllers;

use App\Http\Requests\DistrictRequest;
use App\Http\Services\DistrictService;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    private $districtService;
    public function __construct(DistrictService $districtService)
    {
        $this->districtService = $districtService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_districts = District::query();
            return datatables($report_districts)
                ->editColumn('created_at', function ($district) {
                    return date('d M Y', strtotime($district->created_at));
                })
                ->addColumn('actions', function ($district) {
                    $action = '<a href="' . route('district.edit', ['id' => $district->id]) . '" class="btn btn-sm  btn-info text-white" style="margin-right:10px">' . EDIT_ICON . '</a>';
                    $action .= delete_modal($district->id, 'district.delete') . '</div>';

                    return $action;
                })
                ->rawColumns(['created_at', 'actions'])
                ->make(TRUE);
        }
        return view('district.index');
    }

    public function create()
    {
        return view('district.create');
    }

    public function store(DistrictRequest $request)
    {
        $district = $this->districtService->store($request);
        if ($district['success'] == true) {
            return redirect()->route('district.list')->with('success', $district['message']);
        }
        return redirect()->route('district.list')->with('dismiss', $district['message']);
    }

    public function edit($id = null)
    {
        $district = District::where(['id' => $id])->first();
        if (!empty($district)) {
            return view('district.edit', ['district' => $district]);
        }
        return redirect()->route('district.list')->with('dismiss', __("District not found"));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|unique:districts,name,' . $request->edit_id,
        ]);

        $manufacturer = $this->districtService->update($request);

        if ($manufacturer['success'] == TRUE) {
            return redirect()->route('district.list')->with('success', $manufacturer['message']);
        }
        return redirect()->back()->with('dismiss', $manufacturer['message']);
    }

    public function delete($id = null)
    {
        $district = $this->districtService->delete($id);
        if ($district['success'] == true) {
            return redirect()->route('district.list')->with('success', $district['message']);
        }
        return redirect()->route('district.list')->with('dismiss', $district['message']);
    }
}
