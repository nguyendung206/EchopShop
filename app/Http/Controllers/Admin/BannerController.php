<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Services\BannerService;
use App\Services\StatusService;
use Exception;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected $bannerService;

    protected $statusService;

    public function __construct(BannerService $bannerService, StatusService $statusService)
    {
        $this->bannerService = $bannerService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $banners = $this->bannerService->index($request->all());

        return view('admin.banner.index', compact('banners'));

    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(BannerRequest $request)
    {
        try {
            $this->bannerService->store($request);
            flash('Thêm Banner thành công')->success();

            return redirect()->route('admin.banner.index');
        } catch (Exception $e) {
            flash('Thêm Banner thất bại')->error();

            return redirect()->route('admin.banner.create');
        }
    }

    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        if (! $banner) {
            return back()->with('message', 'Không có Banner tương ứng');
        }

        return view('admin.banner.show', compact('banner'));
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        if (! $banner) {
            return back()->with('message', 'Không có Banner tương ứng');
        }

        return view('admin.banner.edit', compact('banner'));
    }

    public function update(BannerRequest $request, $id)
    {
        try {
            $banner = $this->bannerService->update($request->all(), $id);
            flash('Cập nhật Banner thành công!')->success();

            return redirect()->route('admin.banner.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật Banner!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $check = $this->bannerService->destroy($id);
            if ($check) {
                flash('Xóa Banner thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa Banner!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa Banner!')->error();
        }
    }

    public function changeStatus($id)
    {
        try {
            $banner = Banner::findOrFail($id);
            $this->statusService->changeStatus($banner);
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
