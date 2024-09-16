<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Services\BannerService;
use Exception;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index(Request $request)
    {
        $banners = $this->bannerService->index($request);

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
            $banner = $this->bannerService->update($request, $id);
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

    public function updateStatus(Request $request, $id)
    {
        $banner = Banner::find($id);
        if (! $banner) {
            flash('Sửa thông tin thất bại')->error();

            return back();
        }
        try {
            $updateData = [
                'status' => $request->status,
            ];
            $banner->update($updateData);

            return response()->json([
                'status' => 'success',
                'message' => 'Sửa thông tin thành công.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sửa thông tin thất bại.',
            ], 500);
        }
    }
}