<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getCategories(Request $request)
    {
        try {
            $datas = $this->categoryService->getApiCategories($request->all());

            return response()->json([
                'status' => 200,
                'success' => true,
                'datas' => $datas,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Đã có lỗi xảy ra, vui lòng thử lại!',
                'error' => $e,
            ], 500);
        }

    }
}
