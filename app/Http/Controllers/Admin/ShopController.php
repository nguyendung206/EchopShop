<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\ShopService;
use App\Services\StatusService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $shopService;

    protected $statusService;

    public function __construct(ShopService $shopService, StatusService $statusService)
    {
        $this->shopService = $shopService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $datas = $this->shopService->getShops($request);

        return view('admin.shop.index', compact('datas'));
    }

    public function status($id)
    {
        try {
            $shop = Shop::findOrFail($id);
            $this->statusService->changestatus($shop);
            flash('Thay đổi trạng thái thành công')->success();
        } catch (\Exception $e) {
            flash('Đã có lỗi xảy ra khi thay đổi trạng thái')->error();

            return redirect()->route('admin.shop.index');
        }

        return redirect()->route('admin.shop.index');
    }

    public function show($id)
    {
        $shop = Shop::where('id', $id)->first();

        return view('admin.shop.show', compact('shop'));
    }
}
