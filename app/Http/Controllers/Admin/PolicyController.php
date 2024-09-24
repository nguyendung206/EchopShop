<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PolicyRequest;
use App\Models\Policy;
use App\Services\PolicyService;
use App\Services\StatusService;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    protected $policyService;

    protected $statusService;

    public function __construct(PolicyService $policyService, StatusService $statusService)
    {
        $this->policyService = $policyService;
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $policies = $this->policyService->index($request->all());

        return view('admin.policy.index', compact('policies'));
    }

    public function create()
    {
        return view('admin.policy.create');
    }

    public function store(PolicyRequest $request)
    {
        try {
            $this->policyService->store($request->all());
            flash('Thêm chính sách thành công')->success();

            return redirect()->route('admin.policy.index');
        } catch (Exception $e) {
            flash('Thêm chính sách thất bại')->error();

            return redirect()->route('admin.policy.create');
        }
    }

    public function edit($id)
    {
        $policy = Policy::findOrFail($id);

        return view('admin.policy.edit', compact('policy'));
    }

    public function update(PolicyRequest $request, $id)
    {
        try {
            $policy = $this->policyService->update($request->all(), $id);
            flash('Cập nhật chính sách thành công!')->success();

            return redirect()->route('admin.policy.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật chính sách!')->error();

            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $check = $this->policyService->destroy($id);
            if ($check) {
                flash('Xóa chính sách thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa chính sách!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa chính sách!')->error();
        }
    }

    public function changeStatus($id)
    {
        try {
            $policy = Policy::findOrFail($id);
            $this->statusService->changeStatus($policy);
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
