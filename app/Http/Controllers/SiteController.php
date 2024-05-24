<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteRequest;
use App\Models\Site;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_paymentTo = Site::query();
            return datatables($report_paymentTo)
                ->editColumn('checkin', function ($site) {
                    return '<input type="checkbox" class="item-checkbox" data-id="' . $site->id . '">';
                })
                ->editColumn('created_at', function ($site) {
                    return date('d M Y', strtotime($site->created_at));
                })
                ->addColumn('actions', function ($site) {
                    $action = '<button type="button"
                    data-name="' . $site->name . '"
                    data-type="' . $site->type . '"
                    data-division="' . $site->division . '"
                    data-area="' . $site->area . '"
                    data-mobile_number="' . $site->mobile_number . '"
                     class="btn btn-sm  btn-info text-white action-btn" style="margin-right:10px">' . VIEW_ICON . '</button>';
                    // $action .= status_change_modal($site). '</div>';
                    return $action;
                })
                ->rawColumns(['checkin', 'actions'])
                ->make(TRUE);
        }
        return view('category.site.index');
    }

    public function storeUpdate(SiteRequest $request)
    {
        $site = null;
        if (!empty($request->id)) {
            $site = Site::where(['id' => $request->id])->first();
            if (empty($site)) {
                return redirect()->route('site.list')->with('dismiss', __("No Found"));
            }
        }
        $data = [
            'created_by'       => !empty($site) ? $site->created_by : Auth::user()->id,
            'name'          => $request->name,
            'type'          => $request->type,
            'division'      => $request->division,
            'area'          => $request->area,
            'mobile_number' => parse_contact($request->mobile_number),
        ];
        try {

            // update record
            if (!empty($site)) {
                $site->update($data);
                return redirect()->route('site.list')->with('success', __("Updated successfully"));
            }

            // create new record
            Site::create($data);
            return redirect()->route('site.list')->with('success', __("Added successfully"));
        } catch (Exception $exception) {
            return redirect()->route('site.list')->with('dismiss', $exception->getMessage());
        }
    }

    // edit

    public  function edit($id = null)
    {
        $site = Site::where('id', $id)->first();
        if ($site) {
            return view('category.site.index', ['data' => $site]);
        }
        return redirect()->route('site.list')->with('dismiss', "Not found");
    }


    // delete
    public  function delete($id = null)
    {
        $site = Site::where('id', $id)->first();
        if ($site) {
            $site->delete();
            return redirect()->route('site.list')->with('success', __("deleted successfully"));
        }
        return redirect()->route('site.list')->with('dismiss', "Not found");
    }

    //details
    public function details($id)
    {

        $site = explode('-', $id);
        return response()->json([
            'division' => isset($site) ? $site[2] : '',
            'district' => isset($site) ? $site[2] : '',
            'area' => isset($site) ? $site[3] : ''
        ]);
    }
}
