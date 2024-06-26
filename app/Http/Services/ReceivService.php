<?php

namespace App\Http\Services;

use App\Http\Services\TransactionService;
use App\Models\BankAccount;
use App\Models\Receive;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceivService
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /*
    * * Receive store and update
    */

    public function store($request)
    {
        $site       =  explode('-', $request->site);
        $account    =  explode('-', $request->account);
        $bankAccount = BankAccount::where(['id' => $account[0]])->first();
        if (empty($bankAccount)) {
            return errorResponse("Bank Account not found");
        }

        $others_amount = $request->others_amount ?? 0;
        $receiveData = [
            'created_by'        => Auth::id(),
            'site_id'           => $site[0],
            'name'              => $site[1],
            'district'          => $site[2],
            'area'              => $site[3],

            'account_id'        => isset($account[0]) && $account[0] != "" ? $account[0] : null,
            'bank_name'         => isset($account[1]) ? $account[1] : null,
            'account_no'         => isset($account[2]) ? $account[2] : null,
            'payment_method'    => $request->payment_method,

            'net_payment_amount'    => $request->net_payment_amount,
            'others_amount'     => $others_amount,
            'total'             => $others_amount + $request->net_payment_amount,
            'date'              => $request->date ?? Carbon::now()->toDateString(),
            'short_note'        => $request->short_note
        ];

        if (!empty($request->document)) {
            $receiveData['document'] = fileUpload($request->document, DOCUMENT_PATH);
        }
        try {

            DB::beginTransaction();
            $receive = Receive::create($receiveData);

            $transaction = $this->transactionService->incomeTransaction($receive, "App\Models\Receive", $receive->total, TRANSACTION_RECEIVE);
            if ($transaction['success'] == false) {
                DB::rollBack();
                return errorResponse($transaction['message']);
            }

            DB::commit();
            return successResponse("Receive Added Successfully");
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return errorResponse($e->getMessage());
        }
    }

    /**
     * update
     */
    public function update($request)
    {
        $receive = Receive::where(['id' => $request->id])->first();
        if(empty($receive)) {
            return errorResponse("Receive Not Found");
        }

        $bankAccount = BankAccount::where(['id' => $receive->account_id])->first();
        if (empty($bankAccount)) {
            return errorResponse("Bank Account not found");
        }
      
        $site       =  explode('-', $request->site);
        // $account    =  explode('-', $request->account);
       
        $others_amount = $request->others_amount ?? 0;
        $total = $others_amount + $request->net_payment_amount;

        $receiveData = [
            'site_id'           => $site[0],
            'name'              => $site[1],
            'district'          => $site[2],
            'area'              => $site[3],

            // 'account_id'        => isset($account[0]) && $account[0] != "" ? $account[0] : null,
            // 'bank_name'         => isset($account[1]) ? $account[1] : null,
            'payment_method'    => $request->payment_method,

            'net_payment_amount'  => $request->net_payment_amount,
            'others_amount'     => $others_amount,
            'total'             => $others_amount + $request->net_payment_amount,
            'date'              => $request->date ?? Carbon::now()->toDateString(),
            'short_note'        => $request->short_note
        ];

        if (!empty($request->document)) {
            $receiveData['document'] = fileUpload($request->document, DOCUMENT_PATH, $receive->document);
        }
        try {

            DB::beginTransaction();

            // transaction start
            $transaction = $this->transactionService->incomeTransactionUpdate($receive, "App\Models\Receive", $total);
            if ($transaction['success'] == false) {
                DB::rollBack();
                return errorResponse($transaction['message']);
            }
            // transaction end

            $receive->update($receiveData);
            DB::commit();

            return successResponse("Receive successfuly updated");
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse();
        }
    }



    /**
     * delete
     */
    public function delete($id = null)
    {
        $receive = Receive::where(['id' => $id])->first();
        if (empty($receive)) {
            return errorResponse("Receive doesn't exist");
        }


        try {

            DB::beginTransaction();

            $transaction = $this->transactionService->incomeTransactionDelete($receive, "App\Models\Receive");
            if ($transaction['success'] == false) {
                return errorResponse($transaction['message']);
            }
            $receive->delete();

            DB::commit();

            return successResponse("Receive successfuly deleted");
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse();
        }
    }
}
