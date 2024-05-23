<?php

namespace App\Http\Services;

use App\Http\Services\TransactionService;
use App\Models\BankAccount;
use App\Models\Labour;
use App\Models\LabourSalary;
use App\Models\Salary;
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
        $employee =  explode('-', $request->employee);
        $account =  explode('-', $request->account);

        // $bankAccount = BankAccount::where(['id' => $request->account])->first();
        // if (empty($bankAccount)) {
        //     return errorResponse("Account not found");
        // }
        // if($request->amount > $bankAccount->balance) {
        //     return errorResponse("Insufficient account balance");
        // }

        $salaryData = [
            'created_by'        => Auth::id(),
            'employee_id'       => $employee[0],
            'name'              => $employee[1],
            'designation'       => $employee[2],
            'account_id'        => isset($account[0]) && $account[0] != "" ? $account[0] : null,
            'bank_name'         => isset($account[1]) && $account[1] != ""? $account[1] : null,
            'payment_method'    => $request->payment_method,
            'salary'            => $request->salary,
            'ta_da'             => $request->ta_da,
            'mobile_bill'       => $request->mobile_bill,
            'total'             =>  $request->salary + $request->ta_da + $request->mobile_bill,
            'date'              => $request->date ? $request->date : Carbon::now()->toDateString(),
        ];

        try {

            DB::beginTransaction();

            $salary = Salary::create($salaryData);

            $transaction = $this->transactionService->expenseTransaction($salary, "App\Models\Salary", $salary->total, TRANSACTION_EMPLOYEE_SALARY);
            if ($transaction['success'] == false) {
                DB::rollBack();
                return errorResponse($transaction['message']);
            }
            // transaction end
            DB::commit();
            return successResponse("Salary Added uccessfully");
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
        $employee =  explode('-', $request->employee);
        $account =  explode('-', $request->account);

        // $bankAccount = BankAccount::where(['id' => $request->account])->first();
        // if (empty($bankAccount)) {
        //     return errorResponse("Account not found");
        // }
        // if($request->amount > $bankAccount->balance) {
        //     return errorResponse("Insufficient account balance");
        // }




        $salary =   Salary::where(['id' => $request->id])->first();
        if (empty($salary)) {
            return errorResponse(__("Salary not found"));
        }

        // if($request->amount > ($account->balance + $salary->amount)) {
        //     return errorResponse("Insufficient account balance");
        // }

        $total = $request->salary + $request->ta_da + $request->mobile_bill;
        $salaryData = [
            'employee_id'       => $employee[0],
            'name'              => $employee[1],
            'designation'       => $employee[2],
            // 'account_id'        => isset($account[0]) ? $account[0] : null,
            // 'bank_name'         => isset($account[1]) ? $account[1] : null,
            'payment_method'    => $request->payment_method,
            'salary'            => $request->salary,
            'ta_da'             => $request->ta_da,
            'mobile_bill'       => $request->mobile_bill,
            'total'             =>  $total,
            'date'              => $request->date ? $request->date : Carbon::now()->toDateString(),
        ];

        try {

            DB::beginTransaction();

            // transaction start
            if ($total != $salary->total) {
                $transaction = $this->transactionService->expenseTransactionUpdate($salary, "App\Models\Salary", $total);
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
        $salary = Salary::where(['id' => $id])->first();
        if (empty($salary)) {
            return errorResponse("Salary doesn't exist");
        }


        try {

            DB::beginTransaction();

            $transaction = $this->transactionService->expenseTransactionDelete($salary, "App\Models\Salary");
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
