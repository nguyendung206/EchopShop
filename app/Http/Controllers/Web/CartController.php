<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Services\CartService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function store(CartRequest $request)
    {
        try {
            $result = $this->cartService->store($request);

            if ($request->ajax() || $request->wantsJson()) {
                if ($result['status'] === 200) {
                    return response()->json([
                        'status' => 200,
                        'message' => $result['message'],
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Đã có lỗi xảy ra',
                    ], 500);
                }
            } else {
                return redirect()->route('cart.index');
            }
        } catch (\Exception $e) {
            Log::error('Error adding to cart: '.$e->getMessage());

            return ['status' => 500, 'message' => 'Đã có lỗi xảy ra'];
        }
    }

    public function check(Request $request)
    {
        $result = $this->cartService->check($request);

        if ($result['status'] === 500) {
            return response()->json($result, 500);
        }

        return response()->json($result, 200);
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
                    'status' => 200,
                    'message' => 'Đổi loại hàng thành công',
                    'cart' => $result,

                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Đã có lỗi xảy ra',
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Đã có lỗi xảy ra',
            ], 500);
        }
    }

    public function updateQuantityCart(Request $request, $id)
    {
        try {
            $result = $this->cartService->updateQuantityCart($request->all(), $id);
            if ($result) {

                return response()->json([
                    'status' => 200,
                    'message' => 'Đổi số lượng thành công',
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Đã có lỗi xảy ra',
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Đã có lỗi xảy ra',
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->cartService->updateQuantity($id, $request->input('quantity'));

        if ($cart) {
            return redirect()->route('cart.index')->with('success', 'Cập nhật số lượng thành công.');
        }

        return redirect()->route('cart.index')->with('error', 'Sản phẩm không tìm thấy.');
    }

    public function getCartCount()
    {
        if (Auth::check()) {
            $cartCount = Auth::user()->countCart();

            return response()->json([
                'status' => 200,
                'cartCount' => $cartCount,
            ]);
        }

        return response()->json([
            'status' => 200,
            'cartCount' => 0,
        ]);
    }
}
