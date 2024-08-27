<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Services\ImageService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $query = Brand::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $datas = $query->paginate(5);

        return view('Admin.Brand.index', compact('datas'));
    }

    public function Create()
    {
        $categories = Category::all();
        return view('Admin.Brand.Create', compact('categories'));
    }

    public function SaveCreate(BrandRequest $request)
    {
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->status = Status::from($request->input('status'))->value;
        $brand->category_id = $request->category_id;
        $brand->photo = $this->imageService->uploadImage($request->file('photo'));

        $brand->save();

        flash('Thêm mới loại hàng thành công!')->success();
        return redirect()->route('brand.index');
    }

    public function Update($id)
    {
        $categories = Category::all();
        $brand = Brand::where('id', $id)->first();
        return view('Admin.Brand.Update', compact('brand', 'categories'));
    }

    public function SaveUpdate(BrandRequest $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->status = Status::from($request->input('status'))->value;
        $brand->category_id = $request->category_id;
        $imageService = new ImageService();
        $brand->photo = $imageService->uploadImage($request->file('photo'), 'upload/product', $brand->photo);
        $brand->save();

        flash('Cập nhật loại hàng thành công!')->success();
        return redirect()->route('brand.index');
    }

    public function delete($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            if ($brand->photo && $brand->photo != 'noproduct.png') {
                $oldImage = public_path('upload/product/') . $brand->photo;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            $brand->delete();

            flash('Xóa loại hàng thành công!')->success();
        } catch (\Exception $e) {
            flash('Đã xảy ra lỗi khi xóa loại hàng!')->error();
        }

        return redirect()->route('brand.index');
    }
}
