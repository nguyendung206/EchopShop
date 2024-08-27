<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use App\Services\ImageService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $datas = $query->paginate(5);

        return view('admin.category.index', compact('datas'));
    }

    public function Create()
    {
        return view('Admin.Category.Create');
    }

    public function SaveCreate(CreateCategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->photo = $this->imageService->uploadImage($request->file('photo'));

        $category->save();

        flash('Thêm mới loại hàng thành công!')->success();
        return redirect()->route('category.index');
    }

    public function Update($id)
    {
        $category = Category::where('id', $id)->first();
        return view('Admin.Category.Update', compact('category'));
    }

    public function SaveUpdate(CreateCategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = CategoryStatus::from($request->input('status'))->value;
        $category->photo = $this->imageService->uploadImage($request->file('photo'));
        $category->save();

        flash('Cập nhật loại hàng thành công!')->success();
        return redirect()->route('category.index');
    }

    public function delete($id)
    {
        try {
            $category = Category::findOrFail($id);
            if ($category->photo && $category->photo != 'noproduct.png') {
                $oldImage = public_path('upload/product/') . $category->photo;
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            $category->delete();

            flash('Xóa loại hàng thành công!')->success();
        } catch (\Exception $e) {
            flash('Đã xảy ra lỗi khi xóa loại hàng!')->error();
        }

        return redirect()->route('category.index');
    }
}
