<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ImageService;
use App\Services\StatusService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    protected $statusService;

    public function __construct(CategoryService $categoryService, statusService $statusService)
    {
        $this->categoryService = $categoryService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $datas = $this->categoryService->getCategories($request);
        return view('admin.category.index', compact('datas'));
    }

    public function Create()
    {
        return view('Admin.Category.Create');
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryService->createCategory($request);
        flash('Thêm mới loại hàng thành công!')->success();
        return redirect()->route('category.index');
    }

    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        return view('Admin.Category.Update', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $this->categoryService->updateCategory($request, $id);
        flash('Cập nhật loại hàng thành công!')->success();
        return redirect()->route('category.index');
    }

    public function destroy($id)
    {
        if ($this->categoryService->deleteCategory($id)) {
            flash('Xóa loại hàng thành công!')->success();
        } else {
            flash('Đã xảy ra lỗi khi xóa loại hàng!')->error();
        }

        return redirect()->route('category.index');
    }

    public function status($id)
    {
        $category = Category::findOrFail($id);
        $this->statusService->changeStatus($category);
        flash('Thay đổi trạng thái thành công!')->success();
        return redirect()->route('category.index');
    }
}
