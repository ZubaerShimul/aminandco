<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\ExpenseIncome;
use App\Models\Tender;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function officialExpense(Request $request)
    {
        if ($request->isMethod('post')) {
            $to_date = !empty($request->to_date) ? $request->to_date : Carbon::now()->toDateString();
            if (!empty($request->from_date)) {
                $expenses = ExpenseIncome::where(['is_official' => ENABLE, 'type' => CATEGORY_TYPE_EXPENSE])->where('date', '>=', $request->from_date)->where('date', '<=', $to_date)->get();
            } else {
                $expenses = ExpenseIncome::where(['is_official' => ENABLE, 'type' => CATEGORY_TYPE_EXPENSE])->where('date', '<=', $to_date)->get();
            }
            return view('report.expense.official.report', ['expenses' => $expenses, 'from_date' => $request->from_date, 'to_date' => $to_date]);
        }
        return view('report.expense.official.expense');
    }

    public function tenderExpense(Request $request)
    {
        if ($request->isMethod('post')) {
            $tender = Tender::where(['id' => $request->tender_id])->first();
            if (empty($tender)) {
                return redirect()->back()->with("dismiss", __("Tender not found"));
            }
            $to_date = !empty($request->to_date) ? $request->to_date : Carbon::now()->toDateString();
            if (!empty($request->from_date)) {
                $expenses = ExpenseIncome::where(['is_tender' => ENABLE, 'tender_id' => $request->tender_id, 'type' => CATEGORY_TYPE_EXPENSE])->where('date', '>=', $request->from_date)->where('date', '<=', $to_date)->get();
            } else {
                $expenses = ExpenseIncome::where(['is_tender' => ENABLE, 'tender_id' => $request->tender_id, 'type' => CATEGORY_TYPE_EXPENSE])->where('date', '<=', $to_date)->get();
            }
            return view('report.expense.tender.report', ['tender' => $tender, 'expenses' => $expenses, 'from_date' => $request->from_date, 'to_date' => $to_date]);
        }
        $tenders = Tender::orderBy('id', 'desc')->get();
        return view('report.expense.tender.expense', ['tenders' => $tenders]);
    }
}
