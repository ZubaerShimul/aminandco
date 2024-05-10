<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Http\Services\BankAccountService;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    private $accountService;
    public function __construct(BankAccountService $accountService)
    {
        $this->accountService = $accountService;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $report_categories = BankAccount::query();
            return datatables($report_categories)
                ->editColumn('created_at', function ($account) {
                    return date('d M Y', strtotime($account->created_at));
                })

                ->addColumn('actions', function ($account) {
                    $action = '<a href="' . route('account.edit', ['id' => $account->id]) . '" class="btn btn-sm  btn-info text-white" style="margin-right:10px">' . EDIT_ICON . '</a>';
                    if (!$account->is_cash) {
                        $action .= delete_modal($account->id, 'account.delete') . '</div>';
                    }

                    return $action;
                })
                ->rawColumns(['created_at', 'actions'])
                ->make(TRUE);
        }
        return view('account.index');
    }

    public function create()
    {
        return view('account.create');
    }

    public function store(AccountRequest $request)
    {
        $account = $this->accountService->store($request);
        if ($account['success'] == true) {
            return redirect()->route('account.list')->with('success', $account['message']);
        }
        return redirect()->back()->with('dismiss', $account['message']);
    }

    public function edit($id = null)
    {
        $account = BankAccount::where(['id' => $id])->first();
        if (!empty($account)) {
            return view('account.edit', ['account' => $account]);
        }
        return redirect()->route('account.list')->with('dismiss', __("account not found"));
    }

    public function update(accountRequest $request)
    {
        $manufacturer = $this->accountService->update($request);

        if ($manufacturer['success'] == TRUE) {
            return redirect()->route('account.list')->with('success', $manufacturer['message']);
        }
        return redirect()->back()->with('dismiss', $manufacturer['message']);
    }

    public function delete($id = null)
    {
        $account = $this->accountService->delete($id);
        if ($account['success'] == true) {
            return redirect()->route('account.list')->with('success', $account['message']);
        }
        return redirect()->route('account.list')->with('dismiss', $account['message']);
    }
}
