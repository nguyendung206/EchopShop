<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopRequest;
use App\Services\ShopService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        return view('web.profile.registershop');
    }

    public function store(ShopRequest $request)
    {
        try {
            $this->shopService->createShop($request);

            return redirect()->route('web.registershop.create')
                ->with('success', 'Đăng ký shop thành công! Vui lòng chờ kiểm duyệt từ hệ thống');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi khi đăng ký Shop!')
                ->withInput();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
