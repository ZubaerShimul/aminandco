<?php

namespace App\Http\Services;

use App\Models\Labour;
use Carbon\Carbon;
use Exception;

class LabourService
{
    public function store($request)
    {
        $tender = explode('-', $request->tender);
        $exists = exists(new Labour(), ['phone' => parse_contact($request->phone), 'tender_id' => $tender[0]]);
        if ($exists) {
            return errorResponse(__(" Labour phone alredy has been taken"));
        }
        try {
            Labour::create([
                'user_id'       => 1,
                'tender_id'     => $tender[0],
                'name'          => $request->name,
                'address'       => $request->address,
                'phone'         => parse_contact($request->phone),
                'joining_date'  => $request->joining_date ?? Carbon::now()->toDateString()
            ]);
            return successResponse(__("Labour added successfully"));
        } catch (Exception $e) {
            info($e->getMessage());
            return errorResponse();
        }
    }

    public function update($request)
    {
        $tender = explode('-', $request->tender);
        $exists = exists(new Labour(), ['phone' => parse_contact($request->phone), 'tender_id' => $tender[0]], $request->edit_id);
        if ($exists) {
            return errorResponse(__(" Labour phone alredy has been taken"));
        }

        try {
            $labour = Labour::where('id', $request->edit_id)->first();
            if (!empty($labour)) {

                $labourData = [
                    'user_id'       => 1,
                    'tender_id'     => $tender[0],
                    'name'          => $request->name,
                    'address'       => $request->address,
                    'phone'         => parse_contact($request->phone),
                    'joining_date'  => $request->joining_date ?? Carbon::now()->toDateString()
                ];

                $labour->update($labourData);
                return successResponse(__("Labour updated successfully"));
            }
            return errorResponse(__('Labour not found'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return errorResponse();
        }
    }

    public function delete($id)
    {
        $labour = Labour::where(['id' => $id])->first();
        if (!empty($labour)) {
            $labour->delete();
            return successResponse(__("Labour deleted successfully"));
        }
        return errorResponse(__("Labour not found"));
    }
}
