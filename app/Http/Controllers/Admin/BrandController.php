<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Services\BrandService;
use App\Services\StatusService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;
    protected $statusService;

    public function __construct(BrandService $brandService, StatusService $statusService)
    {
        $this->brandService = $brandService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $datas = $this->brandService->getBrands($request);
        return view('admin.brand.index', compact('datas'));
    }

    public function create()
    {
        $categories = Category::where('status', Status::ACTIVE)->get();
        return view('Admin.brand.Create', compact('categories'));
    }

    public function store(BrandRequest $request)
    {
        $this->brandService->createBrand($request);
        flash('Thêm mới loại hàng thành công!')->success();
        return redirect()->route('brand.index');
    }

    public function edit($id)
    {
        $categories = Category::where('status', Status::ACTIVE)->get();
        $brand = Brand::where('id', $id)->first();
        return view('Admin.brand.Update', compact('brand','categories'));
    }

    public function update(BrandRequest $request, $id)
    {
        $this->brandService->updateBrand($request, $id);
        flash('Cập nhật loại hàng thành công!')->success();
        return redirect()->route('brand.index');
    }

    public function destroy($id)
    {
        if ($this->brandService->deleteBrand($id)) {
            flash('Xóa loại hàng thành công!')->success();
        } else {
            flash('Đã xảy ra lỗi khi xóa loại hàng!')->error();
        }

        return redirect()->route('brand.index');
    }

    public function status($id)
    {
        $brand = Brand::findOrFail($id);
        $this->statusService->changeStatus($brand);
        return redirect()->route('brand.index');
    }
}
