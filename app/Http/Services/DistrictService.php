<?php

namespace App\Http\Services;

use App\Models\District;
use Exception;

class DistrictService
{
    public function store($request)
    {
        try {
            District::create([
                'user_id' => 1,
                'name' => $request->name
            ]);
            return successResponse(__("District successfully added"));
        } catch (Exception $e) {
            info($e->getMessage());
            return errorResponse();
        }
    }

    public function update($request)
    {
        try {
            $district = District::where('id', $request->edit_id)->first();
            if (!empty($district)) {

                $districtData = [
                    'name'          => $request->name,
                ];

                $district->update($districtData);
                return successResponse(__("District added successfully"));
            }
            return errorResponse(__('District not found'));
        } catch (Exception $e) {
            info($e->getMessage());
            return errorResponse();
        }
    }

    public function delete($id)
    {
        $district = District::where([])->first();
        if (!empty($district)) {
            $district->delete();
            return successResponse(__("District deleted successfully"));
        }
        return errorResponse(__("District not found"));
    }
}
