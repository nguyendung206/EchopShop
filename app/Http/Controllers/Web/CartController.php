<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\CartService;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $carts = $this->cartService->getCart();

        return view('web.cart.index', compact('carts'));
    }

    public function store(Request $request)
    {
        try {
            if ($request->ajax() || $request->wantsJson()) {
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
            } else {
                $validatedData = $request->validate([
                    'productUnitId' => 'required',
                ]);
            }

            $result = $this->cartService->store($request);

            return redirect()->route('cart.index');
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function destroy($id)
    {
        try {
            if ($this->cartService->destroy($id)) {
                return redirect()->back()->with('success', 'Xóa thành công!');
            } else {
                return redirect()->back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    public function clear(Request $request)
    {
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được xóa.');
    }

    public function updateProductUnit(Request $request, $id)
    {
        try {
            $result = $this->cartService->updateProductUnit($request->all(), $id);
            if ($result) {

                return response()->json([
                    'status' => 'success',
                    'message' => 'Đổi loại hàng thành công',
                    'cart' => $result,

                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Đã có lỗi xảy ra',
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Đã có lỗi xảy ra',
            ], 500);
        }
    }

    public function updateQuantityCart(Request $request, $id)
    {
        try {
            $result = $this->cartService->updateQuantity($request->all(), $id);
            if ($result) {

                return response()->json([
                    'status' => 'success',
                    'message' => 'Đổi số lượng thành công',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Đã có lỗi xảy ra',
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Đã có lỗi xảy ra',
            ], 500);
        }
    }
}
