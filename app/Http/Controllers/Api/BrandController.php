<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function getBrands(Request $request)
    {
        try {
            $datas = $this->brandService->getBrands($request);

            return response()->json([
                'status' => 200,
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
