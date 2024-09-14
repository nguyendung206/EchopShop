<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Services\BrandService;
use App\Services\StatusService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        try {
            $datas = $this->brandService->getBrands($request);

            return view('admin.brand.index', compact('datas'));
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải danh sách thương hiệu!')->error();

            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $categories = Category::where('status', Status::ACTIVE)->get();

            return view('admin.brand.create', compact('categories'));
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải danh sách danh mục!')->error();

            return redirect()->back();
        }
    }

    public function store(BrandRequest $request)
    {
        try {
            $this->brandService->createBrand($request);
            flash('Thêm mới thương hiệu thành công!')->success();

            return redirect()->route('admin.brand.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi thêm mới thương hiệu!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $categories = Category::where('status', Status::ACTIVE)->get();
            $brand = Brand::findOrFail($id);

            return view('admin.brand.update', compact('brand', 'categories'));
        } catch (ModelNotFoundException $e) {
            flash('Thương hiệu không tồn tại!')->error();

            return redirect()->route('admin.brand.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải thông tin thương hiệu!')->error();

            return redirect()->route('admin.brand.index');
        }
    }

    public function update(BrandRequest $request, $id)
    {
        try {
            $this->brandService->updateBrand($request, $id);
            flash('Cập nhật thương hiệu thành công!')->success();

            return redirect()->route('admin.brand.index');
        } catch (ModelNotFoundException $e) {
            flash('Thương hiệu không tồn tại!')->error();

            return redirect()->route('admin.brand.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật thương hiệu!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            if ($this->brandService->deleteBrand($id)) {
                flash('Xóa thương hiệu thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa thương hiệu!')->error();
            }
        } catch (ModelNotFoundException $e) {
            flash('Thương hiệu không tồn tại!')->error();
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa thương hiệu!')->error();
        }

        return redirect()->route('admin.brand.index');
    }

    public function status($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $this->statusService->changeStatus($brand);
            flash('Thay đổi trạng thái thành công!')->success();
        } catch (ModelNotFoundException $e) {
            flash('Thương hiệu không tồn tại!')->error();
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi thay đổi trạng thái!')->error();
        }

        return redirect()->route('admin.brand.index');
    }
}
