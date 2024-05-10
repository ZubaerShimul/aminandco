<?php

namespace App\Http\Services;

use App\Http\Services\TransactionService;
use App\Models\BankAccount;
use App\Models\Labour;
use App\Models\LabourSalary;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalaryService
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

        // if($request->amount > $account->balance) {
        //     return errorResponse("Insufficient account balance");
        // }

        $salaryData = [
            'paid_by_name'        => $request->paid_by,
            'user_id'           => Auth::id(),
            'tender_id'        => $request->tender,
            'labour_id'        => $request->labour,
            'account_id'        => $bankAccount->id,
            'payment_method'    => $request->payment_method,
            'total_amount'      => $request->total_amount,
            'date'              => $request->date ? $request->date : Carbon::now()->toDateString(),
            'description'       => $request->description,
            'grand_total'       => $request->total_amount,
        ];

        try {

            DB::beginTransaction();

            $salary = LabourSalary::create($salaryData);

            $transaction = $this->transactionService->expenseTransaction($salary, "App\Models\LabourSalary", $salary->account_id, $salary->total_amount, CATEGORY_ID_SALARY_EXPENSE);
            if ($transaction['success'] == false) {
                DB::rollBack();
                return errorResponse($transaction['message']);
            }
            // transaction end
            DB::commit();
            return successResponse("Salary successfully added");
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
        $salary = LabourSalary::where(['id' => $request->edit_id])->first();
        $oldSalary = LabourSalary::where(['id' => $request->edit_id])->first();
        if (empty($salary)) {
            return errorResponse(__("Salary not found"));
        }
        $account = BankAccount::where(['id' => $salary->account_id])->first();
        if (empty($account)) {
            return errorResponse("Account not found");
        }

        $labour = Labour::where(['id' => $request->labour])->first();
        if (empty($labour)) {
            return errorResponse("Labour not found");
        }

        // if($request->amount > ($account->balance + $salary->amount)) {
        //     return errorResponse("Insufficient account balance");
        // }


        $salaryData = [
            'user_id'           => 1,
            'paid_by_name'        => $request->paid_by,
            'tender_id'        => $request->tender,
            'labour_id'        => $request->labour,
            'payment_method'    => $request->payment_method,
            'total_amount'      => $request->total_amount,
            'date'              => $request->date ? $request->date : Carbon::now()->toDateString(),
            'description'       => $request->description,
            'grand_total'       => $request->total_amount,
        ];

        try {

            DB::beginTransaction();

            // transaction start
            if ($request->amount != $oldSalary->amount) {
                $transaction = $this->transactionService->expenseTransactionUpdate($salary, "App\Models\LabourSalary", $salary->amount);
                if ($transaction['success'] == false) {
                    DB::rollBack();
                    return errorResponse($transaction['message']);
                }
            }
            // transaction end

            $salary->update($salaryData);
            DB::commit();

            return successResponse("Salary successfuly updated");
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
        $salary = LabourSalary::where(['id' => $id])->first();
        if (empty($salary)) {
            return errorResponse("Salary doesn't exist");
        }


        try {

            DB::beginTransaction();

            $transaction = $this->transactionService->expenseTransactionDelete($salary, "App\Models\LabourSalary");
            if ($transaction['success'] == false) {
                return errorResponse($transaction['message']);
            }
            $salary->delete();

            DB::commit();

            return successResponse("Salary successfuly deleted");
        } catch (Exception $e) {
            DB::rollBack();
            return errorResponse();
        }
    }
}
