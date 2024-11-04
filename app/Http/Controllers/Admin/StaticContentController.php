<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TypeStaticContent;
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
        $type = $request->query('type');
        if (! TypeStaticContent::isValid($type) || empty($type)) {
            dd($type);

            return redirect()->route('admin.static-content.index', ['type' => $type]);
        }
        $policies = $this->staticCotentService->index($request->all());

        return view('admin.staticContent.index', ['policies' => $policies, 'type' => $type]);
    }

    public function create(Request $request)
    {
        $type = $request->query('type');
        if (! TypeStaticContent::isValid($type) || empty($type)) {
            abort(404);
        }

        return view('admin.staticContent.create', ['type' => $type]);
    }

    public function store(StaticContentRequest $request)
    {
        try {
            $this->staticCotentService->store($request->all());
            flash('Thêm '.TypeStaticContent::from($request->query('type'))->label().' thành công')->success();

            return redirect()->route('admin.static-content.index', ['type' => $request->query('type')]);
        } catch (Exception $e) {
            flash('Thêm '.TypeStaticContent::from($request->query('type'))->label().' thất bại')->error();

            return redirect()->route('admin.static-content.create');
        }
    }

    public function edit(Request $request, $id)
    {
        $type = $request->query('type');
        if (! TypeStaticContent::isValid($type) || empty($type)) {
            abort(404);
        }
        $content = StaticContent::findOrFail($id);

        return view('admin.staticContent.edit', ['content' => $content, 'type' => $type]);
    }

    public function update(StaticContentRequest $request, $id)
    {
        try {
            $this->staticCotentService->update($request->all(), $id);
            flash('Cập nhật '.TypeStaticContent::from($request->query('type'))->label().' thành công!')->success();

            return redirect()->route('admin.static-content.index', ['type' => $request->query('type')]);
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật '.TypeStaticContent::from($request->query('type'))->label().'!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $check = $this->staticCotentService->destroy($id);
            if ($check) {
                flash('Xóa '.TypeStaticContent::from($request->query('type'))->label().' thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa '.TypeStaticContent::from($request->query('type'))->label().'!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa '.TypeStaticContent::from($request->query('type'))->label().'!')->error();
        }
    }

    public function changeStatus($id)
    {
        try {
            $policy = StaticContent::findOrFail($id);
            $this->statusService->changeStatus($policy);
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
