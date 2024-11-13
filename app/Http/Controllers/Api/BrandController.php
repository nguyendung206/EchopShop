<?php

namespace App\Http\Controllers\Api;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Brand;

class BrandController extends Controller
{
    public function getBrands()
    {
        try {
            $datas = Brand::where('status', Status::ACTIVE)->get();

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
