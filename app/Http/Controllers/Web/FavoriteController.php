<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

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
        $result = $this->favoriteService->store($request);
        if ($result) {
            flash('Thêm yêu thích thành công')->success();

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm yêu thích thành công',
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
            return response()->json([
                'status' => 'success',
                'message' => 'Xoá yêu thích thành công',
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Đã có lỗi xảy ra',
        ], 500);
    }
}
