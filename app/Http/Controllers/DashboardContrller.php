<?php

namespace App\Http\Controllers;

use App\Models\ExpenseIncome;
use App\Models\Payment;
use App\Models\Tender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class DashboardContrller extends Controller
{
    public function index()
    {
        $data['user'] = Auth::user();
        $data['total_received'] = Payment::sum('total');
        $data['total_budget'] = 0;
        $data['toal_due_amount'] = 0;
        $data['recent_tenders'] = [];
        $data['official_expenses'] = ExpenseIncome::whereDate('date', Carbon::now()->toDateString())->orderBy('id','desc')->get();


        return view('dashboard', $data);
    }

    public function changeLanguage(Request $request)
    {
        try {
            if (!in_array($request->lang, ['en', 'bn'])) {
                return redirect()->back()->with(['dismiss' => __('Please select proper language')]);
            }
            app()->setLocale($request->lang);
            Session::put('language', $request->lang);
            return redirect()->back()->with(['success' => __('Language changed successfully')]);
        } catch (\Exception $exception) {
            return redirect()->back()->with(['dismiss' => __('Something went wrong!')]);
        }
    }
}
