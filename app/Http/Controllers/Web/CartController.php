<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        return view('web.cart.index');
    }

    public function store(Request $request)
    {
        $result = $this->cartService->store($request);
        if ($result) {
            flash('Thêm vào giỏ thành công')->success();

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm vào giỏ thành công',
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Đã có lỗi xảy ra',
        ], 500);
    }
}
