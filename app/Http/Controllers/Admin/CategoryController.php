<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\StatusService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    protected $statusService;

    public function __construct(CategoryService $categoryService, StatusService $statusService)
    {
        $this->categoryService = $categoryService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        try {
            $datas = $this->categoryService->getCategories($request);

            return view('admin.category.index', compact('datas'));
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải danh sách loại hàng!')->error();

            return redirect()->back();
        }
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            $this->categoryService->createCategory($request);
            flash('Thêm mới loại hàng thành công!')->success();

            return redirect()->route('category.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi thêm mới loại hàng!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);

            return view('admin.category.update', compact('category'));
        } catch (ModelNotFoundException $e) {
            flash('Loại hàng không tồn tại!')->error();

            return redirect()->route('category.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải thông tin loại hàng!')->error();

            return redirect()->route('category.index');
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $this->categoryService->updateCategory($request, $id);
            flash('Cập nhật loại hàng thành công!')->success();

            return redirect()->route('category.index');
        } catch (ModelNotFoundException $e) {
            flash('Loại hàng không tồn tại!')->error();

            return redirect()->route('category.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật loại hàng!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            if ($this->categoryService->deleteCategory($id)) {
                flash('Xóa loại hàng thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa loại hàng!')->error();
            }
        } catch (ModelNotFoundException $e) {
            flash('Loại hàng không tồn tại!')->error();
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa loại hàng!')->error();
        }

        return redirect()->route('category.index');
    }

    public function status($id)
    {
        try {
            $category = Category::findOrFail($id);
            $this->statusService->changeStatus($category);
            flash('Thay đổi trạng thái thành công!')->success();
        } catch (ModelNotFoundException $e) {
            flash('Loại hàng không tồn tại!')->error();
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi thay đổi trạng thái!')->error();
        }

        return redirect()->route('category.index');
    }
}
