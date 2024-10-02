<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Services\FavoriteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function index(Request $request)
    {
        $favorites = $this->favoriteService->getProduct(9);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'productHtml' => view('web.product.listFavoriteProduct', compact('favorites'))->render(),
                'hasMorePages' => $favorites->hasMorePages(),
            ]);
        }

        return view('web.product.favoriteProduct', compact('favorites'));
    }

    public function store(Request $request)
    {
        $result = $this->favoriteService->store($request->all());
        if ($result) {
            flash('Thêm yêu thích thành công')->success();
            $favoriteCount = Favorite::where('user_id', Auth::id())->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm yêu thích thành công',
                'favoriteCount' => $favoriteCount,
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Đã có lỗi xảy ra',
        ], 500);
    }

    public function destroy($id)
    {
        $result = $this->favoriteService->destroy($id);
        if ($result) {
            $favoriteCount = Favorite::where('user_id', Auth::id())->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Xoá yêu thích thành công',
                'favoriteCount' => $favoriteCount,
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Đã có lỗi xảy ra',
        ], 500);
    }
}
