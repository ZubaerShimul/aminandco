<?php

namespace App\Http\Controllers;

use App\Models\Receive;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReceiveReportController extends Controller
{
    public function index(Request $request)
    {
        $to_date = !empty($request->to_date) ? $request->to_date : Carbon::now()->toDateString();
        $from_date = !empty($request->from_date) ? $request->$request->from_date : null;

        if ($request->isMethod('post')) {

            if (!empty($request->from_date)) {
                $receives = Receive::where('date', '>=', $request->from_date)->where('date', '<=', $to_date)->get();
            } else {
                $receives = Receive::where('date', '<=', $to_date)->get();
            }
            return view('report.receive.tender.report', ['receives' => $receives, 'from_date' => $request->from_date, 'to_date' => $to_date]);
        }
        $receives = Receive::where('date', '<=', $to_date)->get();

        return view('report.receive.report', ['receives' => $receives, 'to_date' => $to_date, 'from_date' => $from_date ]);
    }

    public function print(Request $request)
    {
        $to_date = !empty($request->to_date) ? $request->to_date : Carbon::now()->toDateString();
        $from_date = !empty($request->from_date) ? $request->$request->from_date : null;

        $receives = Receive::where('date', '<=', $to_date)->get();

        return view('report.receive.print', ['receives' => $receives, 'to_date' => $to_date, 'from_date' => $from_date ]);
   
    }
}
