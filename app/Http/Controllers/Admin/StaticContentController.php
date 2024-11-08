<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaticContentRequest;
use App\Models\StaticContent;
use App\Services\StaticContentService;
use App\Services\StatusService;
use Exception;
use Illuminate\Http\Request;

class StaticContentController extends Controller
{
    protected $staticCotentService;

    protected $statusService;

    public function __construct(StaticContentService $staticCotentService, StatusService $statusService)
    {
        $this->staticCotentService = $staticCotentService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $contents = $this->staticCotentService->index($request->all());

        return view('admin.staticContent.index', ['contents' => $contents]);
    }

    public function create(Request $request)
    {
        return view('admin.staticContent.create');
    }

    public function store(StaticContentRequest $request)
    {
        try {
            $this->staticCotentService->store($request->all());
            flash('Thêm nội dung thành công')->success();

            return redirect()->route('admin.static-content.index');
        } catch (Exception $e) {
            flash('Thêm nội dung thất bại')->error();

            return redirect()->route('admin.static-content.create');
        }
    }

    public function edit(Request $request, $id)
    {
        $content = StaticContent::findOrFail($id);

        return view('admin.staticContent.edit', ['content' => $content]);
    }

    public function update(StaticContentRequest $request, $id)
    {
        try {
            $this->staticCotentService->update($request->all(), $id);
            flash('Cập nhật nội dung thành công!')->success();

            return redirect()->route('admin.static-content.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật nội dung!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $check = $this->staticCotentService->destroy($id);
            if ($check) {
                flash('Xóa nội dung thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa nội dung!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa nội dung!')->error();
        }
    }

    public function changeStatus($id)
    {
        try {
            $content = StaticContent::findOrFail($id);
            $this->statusService->changeStatus($content);
            flash('Thay đổi trạng thái thành công!')->success();

            return response()->json([
                'status' => 200,
                'message' => 'Sửa thông tin thành công.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Sửa thông tin thất bại.',
            ], 500);
        }

    }
}
