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
            $favoriteCount = Favorite::getUserFavoriteCount(Auth::id());

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm yêu thích thành công',
                'favoriteCount' => $favoriteCount,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Đã có lỗi xảy ra',
        ], 500);
    }

    public function destroy($id)
    {
        $result = $this->favoriteService->destroy($id);
        if ($result) {
            $favoriteCount = Favorite::getUserFavoriteCount(Auth::id());

            return response()->json([
                'status' => 'success',
                'message' => 'Xoá yêu thích thành công',
                'favoriteCount' => $favoriteCount,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Đã có lỗi xảy ra',
        ], 500);
    }
}
