<?php

namespace App\Http\Services;

use App\Models\Tender;
use Exception;

class TenderService
{
    public function store($request)
    {
        $exists = exists(new Tender(), ['tender_no' => $request->tender_no]);
        if ($exists) {
            return errorResponse(__($request->tender_no . " no tender alredy has been taken"));
        }

        // payment status
        $budget = $request->has('budget') ? $request->budget : 0;
        $paid = $request->has('opening_amount') ? $request->opening_amount : 0;
        // if ($paid > $budget) {
        //     return redirect()->route('tender.list')->with('dismiss', __("Opening amount should not be greater than budget"));
        // }

        $district  = explode('-', $request->district);
        $payment_statuts = 'Unpaid';
        // if ($budget > 0) {

        //     $due = $budget - $paid;
        //     if ($due == 0 || $due < 0) {
        //         $payment_statuts = 'Paid';
        //     } else if ($due != (float)$budget) {
        //         $payment_statuts = 'Partial'; 
        //     } else if ($due == (float) $budget) {
        //         $payment_statuts = 'Unpaid';
        //     }
        // }

        $data = [
            'tender_no'     => $request->tender_no,
            'name'          => $request->name,
            'account_id'    => $request->account,
            'working_time'  => $request->working_time,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'opening_amount' => $paid,
            'budget'        => $request->budget,
            'status'         => $request->status ? $request->status : TENDER_STATUS_PENDING,
            'payment_status' => $payment_statuts,
            'district_id'    => $district[0],
            'district_name'  => $district[1],
        ];

        try {
            Tender::create($data);
            return successResponse(__("Tender successfully added"));
        } catch (Exception $e) {
            info($e->getMessage());
            return errorResponse();
        }
    }

    public function update($request)
    {
        $exists = exists(new Tender(), ['tender_no' => $request->tender_no], $request->edit_id);
        if ($exists) {
            return errorResponse(__($request->tender_no . " tender alredy has been taken"));
        }
        
        // payment status
        $budget = $request->has('budget') ? $request->budget : 0;
        $paid = $request->has('opening_amount') ? $request->opening_amount : 0;
        // if ($paid > $budget) {
        //     return redirect()->route('tender.list')->with('dismiss', __("Opening amount should not be greater than budget"));
        // }

        $district  = explode('-', $request->district);
        $payment_statuts = 'Unpaid';

        try {
            $tender = Tender::where('id', $request->edit_id)->first();
            if (!empty($tender)) {

                $tenderData = [
                    'tender_no'     => $request->tender_no,
                    'name'          => $request->name,
                    'account_id'    => $request->account,
                    'working_time'  => $request->working_time,
                    'start_date'    => $request->start_date,
                    'end_date'      => $request->end_date,
                    'opening_amount' => $paid,
                    'budget'        => $request->budget,
                    'status'         => $request->status ? $request->status : TENDER_STATUS_PENDING,
                    'payment_status' => $payment_statuts,
                    'district_id'    => $district[0],
                    'district_name'  => $district[1],
                ];

                $tender->update($tenderData);
                return successResponse(__("Tender updated successfully"));
            }
            return errorResponse(__('Tender not found'));
        } catch (Exception $e) {
            info($e->getMessage());
            return errorResponse();
        }
    }

    public function delete($id)
    {
        $tender = Tender::where(['id' => $id])->first();
        if (!empty($tender)) {
            $tender->delete();
            return successResponse(__("Tender deleted successfully"));
        }
        return errorResponse(__("Tender not found"));
    }
}
