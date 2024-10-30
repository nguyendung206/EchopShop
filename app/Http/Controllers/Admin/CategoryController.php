<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CategoryExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Imports\CategoryImport;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\StatusService;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

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
            if (isset($request->is_export)) {
                return Excel::download(new CategoryExport($datas), 'category.xlsx');
            }

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

            return redirect()->route('admin.category.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi thêm mới loại hàng!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);

            return view('admin.category.edit', compact('category'));
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi tải thông tin loại hàng!')->error();

            return redirect()->route('admin.category.index');
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $this->categoryService->updateCategory($request, $id);
            flash('Cập nhật loại hàng thành công!')->success();

            return redirect()->route('admin.category.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật loại hàng!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->categoryService->deleteCategory($id);
            if ($result) {
                flash('Xóa loại hàng thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa loại hàng!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa loại hàng!')->error();
        }

        return redirect()->route('admin.category.index');
    }

    public function status($id)
    {
        try {
            $category = Category::findOrFail($id);
            $this->statusService->changeStatus($category);
            flash('Thay đổi trạng thái thành công!')->success();

            return redirect()->route('admin.category.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi thay đổi trạng thái!')->error();

            return redirect()->route('admin.category.index');
        }
    }

    public function import(Request $request)
    {
        try {

            $file = $request->file('fileImport');
            $data = Excel::toArray(new CategoryImport, $file);
            if (empty($data) || count($data[0]) == 0) {
                flash('Tải file lên thất bại!')->error();

                return redirect()->back()->withErrors([
                    'data' => 'File rỗng không thể import dữ liệu',
                ]);
            }
            $rows = $data[0];
            $previewData = array_slice($rows, 0, 1); // Lấy 10 hàng đầu tiên
            if (! isset($previewData[0]['slug']) && ! isset($previewData[0]['name']) && ! isset($previewData[0]['description']) && ! isset($previewData[0]['photo']) && ! isset($previewData[0]['status'])) {
                flash('Tải file lên thất bại!')->error();

                return redirect()->back()->withErrors([
                    'header' => 'Dòng đầu tiên trong file phải là tên của các cột: slug, name, description, photo, status',
                ]);
            }

            $file = $request->file('fileImport');
            Excel::import(new CategoryImport, $file);

            flash('Tải file lên thành công!')->success();

            return redirect()->back();
        } catch (ValidationException $e) {
            flash('Tải file lên thất bại!')->error();
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $row = $failure->row();
                foreach ($failure->errors() as $error) {
                    $messages[] = "Có lỗi ở dòng {$row}. {$error}";
                }
            }

            return redirect()->back()->withErrors($messages);
        }
    }
}
