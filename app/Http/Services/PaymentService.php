<?php

namespace App\Http\Services;

use App\Http\Services\TransactionService;
use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    private $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /*
    * * Payment store and update
    */

    public function store($request)
    {
        $payment_to =  explode('-', $request->payment_to);
        $site       =  explode('-', $request->site);
        $account    =  explode('-', $request->account);
        // $bankAccount = BankAccount::where(['id' => $request->account])->first();
        // if (empty($bankAccount)) {
        //     return errorResponse("Account not found");
        // }
        // if($request->amount > $bankAccount->balance) {
        //     return errorResponse("Insufficient account balance");
        // }

        $others_amount = $request->others_amount ?? 0;
        $paymentData = [
            'created_by'        => Auth::id(),
            'payment_to_id'     => $payment_to[0],
            'name'              => $payment_to[1],

            'site_id'           => $site[0],
            'site_name'         => $site[1],
            'district'          => $site[2],
            'area'              => $site[3],

            'account_id'        => isset($account[0]) && $account[0] != "" ? $account[0] : null,
            'bank_name'         => isset($account[1]) ? $account[1] : null,
            'payment_method'    => $request->payment_method,

            'site_bank_name'    => $request->site_bank_name,
            'site_account_no'   => $request->account_no,
            'net_payment_amount'    => $request->net_payment_amount,
            'others_amount'     => $others_amount,
            'total'             => $others_amount + $request->net_payment_amount,
            'date'              => $request->date ?? Carbon::now()->toDateString(),
            'short_note'        => $request->short_note
        ];

        if (!empty($request->document)) {
            $paymentData['document'] = fileUpload($request->document, DOCUMENT_PATH);
        }

        try {

            DB::beginTransaction();
            $payment = Payment::create($paymentData);

            $transaction = $this->transactionService->expenseTransaction($payment, "App\Models\Payment", $payment->total, TRANSACTION_EMPLOYEE_PAYMENT);
            if ($transaction['success'] == false) {
                DB::rollBack();
                return errorResponse($transaction['message']);
            }

            DB::commit();
            return successResponse("Payment Added Successfully");
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse($e->getMessage());
        }
    }

    /**
     * update
     */
    public function update($request)
    {
        $payment = Payment::where(['id' => $request->id])->first();
        if (empty($payment)) {
            return errorResponse("Payment Not Found");
        }
        $payment_to =  explode('-', $request->payment_to);
        $site       =  explode('-', $request->site);
        // $account    =  explode('-', $request->account);
        // $bankAccount = BankAccount::where(['id' => $request->account])->first();
        // if (empty($bankAccount)) {
        //     return errorResponse("Account not found");
        // }
        // if($request->amount > $bankAccount->balance) {
        //     return errorResponse("Insufficient account balance");
        // }

        $others_amount = $request->others_amount ?? 0;
        $total = $others_amount + $request->net_payment_amount;

        $paymentData = [
            'payment_to_id'     => $payment_to[0],
            'name'              => $payment_to[1],

            'site_id'           => $site[0],
            'site_name'         => $site[1],
            'district'          => $site[2],
            'area'              => $site[3],

            // 'account_id'        => isset($account[0]) && $account[0] != "" ? $account[0] : null,
            // 'bank_name'         => isset($account[1]) ? $account[1] : null,
            'payment_method'    => $request->payment_method,

            'site_bank_name'    => $request->site_bank_name,
            'site_account_no'   => $request->account_no,
            'net_payment_amount'    => $request->net_payment_amount,
            'others_amount'     => $others_amount,
            'total'             => $others_amount + $request->net_payment_amount,
            'date'              => $request->date ?? $payment->date,
            'short_note'        => $request->short_note
        ];

        if (!empty($request->document)) {
            $paymentData['document'] = fileUpload($request->document, DOCUMENT_PATH, $payment->document);
        }

        try {

            DB::beginTransaction();

            // transaction start
            $transaction = $this->transactionService->expenseTransactionUpdate($payment, "App\Models\Payment", $total);
            if ($transaction['success'] == false) {
                DB::rollBack();
                return errorResponse($transaction['message']);
            }
            // transaction end

            $payment->update($paymentData);
            DB::commit();

            return successResponse("Payment successfuly updated");
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
        $payment = Payment::where(['id' => $id])->first();
        if (empty($payment)) {
            return errorResponse("Payment doesn't exist");
        }


        try {

            DB::beginTransaction();

            $transaction = $this->transactionService->expenseTransactionDelete($payment, "App\Models\Payment");
            if ($transaction['success'] == false) {
                return errorResponse($transaction['message']);
            }
            $payment->delete();

            DB::commit();

            return successResponse("Payment successfuly deleted");
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse();
        }
    }
}
