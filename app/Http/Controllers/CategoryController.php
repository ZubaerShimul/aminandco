<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Services\CategoryService;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index(Request $request)
    {
        $category_type = $request->input('category_type');

        if ($request->ajax()) {
            $report_categories = Category::where(['read_only' => DISABLE]);
            if(!empty($category_type)) {
                $report_categories->where(['type' => $category_type]);
            }

            $expense = '<span class="badge bg-success">' . __('Expense') . '</span>';
            $income = '<span class="badge bg-danger">' . __('Income') . '</span>';

            return datatables($report_categories)
                ->editColumn('created_at', function ($category) {
                    return date('d M Y', strtotime($category->created_at));
                })
                ->editColumn('type', function ($category) use ($expense, $income) {
                    return $category->type == CATEGORY_TYPE_EXPENSE ? $expense : $income;
                })

                ->addColumn('actions', function ($category) {
                    $action = '<a href="' . route('category.edit', ['id' => $category->id]) . '" class="btn btn-sm  btn-info text-white" style="margin-right:10px">' . EDIT_ICON . '</a>';
                    $action .= delete_modal($category->id, 'category.delete') . '</div>';

                    return $action;
                })
                ->rawColumns(['created_at', 'type','actions'])
                ->make(TRUE);
        }
        return view('category.index');
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService->store($request);
        if ($category['success'] == true) {
            return redirect()->route('category.list')->with('success', $category['message']);
        }
        return redirect()->back()->with('dismiss', $category['message']);
    }

    public function edit($id = null)
    {
        $category = Category::where(['id' => $id])->first();
        if (!empty($category)) {
            return view('category.edit', ['category' => $category]);
        }
        return redirect()->route('category.list')->with('dismiss', __("category not found"));
    }

    public function update(CategoryRequest $request)
    {
        $manufacturer = $this->categoryService->update($request);

        if ($manufacturer['success'] == TRUE) {
            return redirect()->route('category.list')->with('success', $manufacturer['message']);
        }
        return redirect()->back()->with('dismiss', $manufacturer['message']);
    }

    public function delete($id = null)
    {
        $category = $this->categoryService->delete($id);
        if ($category['success'] == true) {
            return redirect()->route('category.list')->with('success', $category['message']);
        }
        return redirect()->route('category.list')->with('dismiss', $category['message']);
    }
}
