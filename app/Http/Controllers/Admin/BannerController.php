<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Services\BannerService;
use App\Http\Requests\BannerRequest;

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
            return view('admin.Banner.index', compact('banners'));
       
    }

  
    public function create()
    {
        return view('admin.Banner.create');
    }

    
    public function store(BannerRequest $request)
    {
        try {
            $this->bannerService->store($request);
            flash('Thêm Banner thành công')->success();
            return redirect()->route('banner.create');
        } catch (Exception $e) {
            flash('Thêm Banner thất bại')->error();
            return redirect()->route('Banner.create');
        }
    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        if(!$banner) {
            return back()->with('message', 'Không có Banner tương ứng');
        }
        return view('admin.Banner.edit', compact('banner'));
    }

   
    public function update(Request $request, $id)
    {
        try {
            $banner = $this->bannerService->update($request, $id);
            flash('Cập nhật Banner thành công!')->success();
            return redirect()->route('banner.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật Banner!')->error();
            return redirect()->back()->withInput();
        }
    }

   
    public function destroy($id)
    {
        try {
            if ($this->bannerService->destroy($id)) {
                flash('Xóa Banner thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa Banner!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa Banner!')->error();
        }
    }

    public function updateStatus(Request $request, $id) {
        $banner = Banner::find($id);
        if(!$banner) {
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
                'message' => 'Sửa thông tin thành công.'
            ], 200);
        }  catch (QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sửa thông tin thất bại.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sửa thông tin thất bại.'
            ], 500);
        }
    }
}
