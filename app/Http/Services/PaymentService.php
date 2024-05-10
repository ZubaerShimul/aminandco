<?php

namespace App\Http\Services;

use App\Http\Services\TransactionService;
use App\Models\BankAccount;
use App\Models\Payment;
use App\Models\Tender;
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
    * * Salary store and update
    */

    public function store($request)
    {
        $bankAccount = BankAccount::where(['id' => $request->account])->first();
        if (empty($bankAccount)) {
            return errorResponse("Account not found");
        }

        $paymentData = [
            'user_id'           => Auth::id(),
            'tender_id'        => $request->tender,
            'account_id'        => $bankAccount->id,

            'receiver'        => $request->receiver,
            'bank_name'        => $request->bank_name,
            'check_no'        => $request->check_no,
            'payment_method'    => $request->payment_method,
            'total_amount'      => $request->total_amount,
            'date'              => $request->date ? $request->date : Carbon::now()->toDateString(),
            'description'       => $request->description,
            'grand_total'       => $request->total_amount,
            'category_id'       => CATEGORY_ID_PAYMENT_INCOME
        ];

        try {

            DB::beginTransaction();

            $payment = Payment::create($paymentData);

            $transaction = $this->transactionService->incomeTransaction($payment, "App\Models\Payment", $payment->account_id, $payment->total_amount, CATEGORY_ID_PAYMENT_INCOME);
            if ($transaction['success'] == false) {
                DB::rollBack();
                return errorResponse($transaction['message']);
            }
            // transaction end
            DB::commit();
            return successResponse("Payment successfully added");
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
        $payment = Payment::where(['id' => $request->edit_id])->first();
        $oldSalary = Payment::where(['id' => $request->edit_id])->first();
        if (empty($payment)) {
            return errorResponse(__("Salary not found"));
        }
        $account = BankAccount::where(['id' => $payment->account_id])->first();
        if (empty($account)) {
            return errorResponse("Account not found");
        }
        $tender = Tender::where(['id' => $request->tender])->first();
        if (empty($tender)) {
            return errorResponse("Tender not found");
        }

        $paymentData = [
            'user_id'           => Auth::id(),
            'receiver'        => $request->receiver,
            'bank_name'        => $request->bank_name,
            'check_no'        => $request->check_no,
            'tender_id'        => $request->tender,
            'payment_method'    => $request->payment_method,
            'total_amount'      => $request->total_amount,
            'date'              => $request->date ? $request->date : Carbon::now()->toDateString(),
            'description'       => $request->description,
            'grand_total'       => $request->total_amount,
        ];

        try {

            DB::beginTransaction();

            // transaction start
            $transaction = $this->transactionService->incomeTransactionUpdate($payment, "App\Models\Payment", $request->total_amount);
            if ($transaction['success'] == false) {
                return errorResponse($transaction['message']);
            }

            // transaction end

            $payment->update($paymentData);
            DB::commit();

            return successResponse("Payment successfuly updated");
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse($e->getMessage());
        }
    }



    /**
     * delete
     */
    public function delete($id = null)
    {
        $payment = Payment::where(['id' => $id])->first();
        if (empty($payment)) {
            return errorResponse("Salary doesn't exist");
        }

        try {

            DB::beginTransaction();

            $transaction = $this->transactionService->incomeTransactionDelete($payment, "App\Models\Payment");
            if ($transaction['success'] == false) {
                return errorResponse($transaction['message']);
            }
            $payment->delete();

            DB::commit();

            return successResponse("Salary successfuly deleted");
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse();
        }
    }
}
