<?php

namespace App\Http\Services;

use App\Models\Category;
use Exception;

class CategoryService
{
    public function store($request)
    {
        $exists = exists(new Category(), ['name' => $request->name, 'type' => $request->category_type]);
        if ($exists) {
            return errorResponse(__($request->category_type . " category name alredy has been taken"));
        }
        try {
            Category::create([
                'user_id' => 1,
                'name' => $request->name,
                'type' => $request->category_type
            ]);
            return successResponse(__("Category successfully added"));
        } catch (Exception $e) {
            info($e->getMessage());
            return errorResponse();
        }
    }

    public function update($request)
    {
        $exists = exists(new Category(), ['name' => $request->name, 'type' => $request->category_type], $request->edit_id);
        if ($exists) {
            return errorResponse(__($request->category_type . " category name alredy has been taken"));
        }

        try {
            $Category = Category::where('id', $request->edit_id)->first();
            if (!empty($Category)) {

                $CategoryData = [
                    'user_id' => 1,
                    'name' => $request->name,
                    'type' => $request->category_type
                ];

                $Category->update($CategoryData);
                return successResponse(__("Category updated successfully"));
            }
            return errorResponse(__('Category not found'));
        } catch (Exception $e) {
            info($e->getMessage());
            return errorResponse();
        }
    }

    public function delete($id)
    {
        $Category = Category::where(['id' => $id])->first();
        if (!empty($Category)) {
            $Category->delete();
            return successResponse(__("Category deleted successfully"));
        }
        return errorResponse(__("Category not found"));
    }
}
