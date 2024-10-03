<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\CartService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $result = $this->cartService->store($request);
        $cartCount = Cart::where('user_id', Auth::id())->count();
        if ($result['status'] === 200) {
            return response()->json([
                'status' => 200,
                'message' => $result['message'],
                'cartCount' => $cartCount,
            ], 200);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Đã có lỗi xảy ra',
        ], 500);
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
}
