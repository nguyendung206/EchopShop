<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
use App\Services\PartnerService;
use App\Services\StatusService;
use Exception;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    protected $partnerService;

    public function __construct(PartnerService $partnerService, StatusService $statusService)
    {
        $this->partnerService = $partnerService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $partners = $this->partnerService->index($request->all());

        return view('admin.partner.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partner.create');
    }

    public function store(PartnerRequest $request)
    {
        try {
            $this->partnerService->store($request->all());
            flash('Thêm partner thành công')->success();

            return redirect()->route('admin.partner.index');
        } catch (Exception $e) {
            flash('Thêm partner thất bại')->error();

            return redirect()->route('admin.partner.create');
        }
    }

    public function show($id)
    {
        $partner = Partner::findOrFail($id);
        if (! $partner) {
            return back()->with('message', 'Không có đối tác tương ứng');
        }

        return view('admin.Partner.show', compact('partner'));
    }

    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        if (! $partner) {
            return back()->with('message', 'Không có đối tác tương ứng');
        }

        return view('admin.partner.edit', compact('partner'));
    }

    public function update(PartnerRequest $request, $id)
    {
        try {
            $partner = $this->partnerService->update($request->all(), $id);
            flash('Cập nhật đối tác thành công!')->success();

            return redirect()->route('admin.partner.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật đối tác!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $check = $this->partnerService->destroy($id);
            if ($check) {
                flash('Xóa đối tác thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa đối tác!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa đối tác!')->error();
        }
    }

    public function changeStatus($id)
    {
        try {
            $partner = Partner::findOrFail($id);
            $this->statusService->changeStatus($partner);
            flash('Thay đổi trạng thái thành công!')->success();

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
