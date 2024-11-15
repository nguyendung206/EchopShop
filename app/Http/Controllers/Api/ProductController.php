<?php

namespace App\Http\Controllers\Api;

use App\Enums\Status;
use App\Http\ApiRequests\ApiProductRequest;
use App\Http\Controllers\Controller;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function store(ApiProductRequest $request)
    {
        try {
            $user = $request->user()->load('shop');
            $request['user_id'] = $user->id;
            $request['shop_id'] = $user->shop->id;
            $request['status'] = Status::INACTIVE->value;
            $product = $this->productService->createProduct($request);
            if ($product) {
                if ($request->unittype == 1) {
                    $quantity = $request->quantity;

                    $this->productService->createProductUnit([
                        'type' => $request->unittype,
                        'product_id' => $product->id,
                        'color' => null,
                        'size' => null,
                        'quantity' => $quantity > 0 ? $quantity : 1,
                    ]);
                } elseif ($request->unittype == 2) {
                    $colors = $request->input('colors', []);
                    $sizes = $request->input('sizes', []);
                    $quantities = $request->input('quantities', []);

                    foreach ($quantities as $index => $quantity) {
                        $this->productService->createProductUnit([
                            'type' => $request->unittype,
                            'product_id' => $product->id,
                            'color' => $colors[$index] ?? '',
                            'size' => $sizes[$index] ?? '',
                            'quantity' => $quantity > 0 ? $quantity : 1,
                        ]);
                    }
                }

                return response()->json([
                    'status' => 200,
                    'success' => true, 'message' => 'Sản phẩm đã được thêm thành công!',
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Đăng bài thất bại.',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Đã có lỗi xảy ra, vui lòng thử lại!',
                'error' => $e,
            ], 500);
        }
    }
}
