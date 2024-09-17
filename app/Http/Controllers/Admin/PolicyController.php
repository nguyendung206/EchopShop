<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PolicyRequest;
use App\Models\Policy;
use App\Services\PolicyService;
use App\Services\StatusService;


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
        $policies = $this->policyService->index($request);
        return view('admin.policy.index',compact('policies'));
    }


    public function create()
    {
        return view('admin.policy.create');
    }

    
    public function store(PolicyRequest $request)
    {
        try {
            $this->policyService->store($request);
            flash('Thêm điều khoản thành công')->success();

            return redirect()->route('admin.policy.index');
        } catch (Exception $e) {
            flash('Thêm điều khoản thất bại')->error();

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
            $policy = $this->policyService->update($request, $id);
            flash('Cập nhật điều khoản thành công!')->success();

            return redirect()->route('admin.policy.index');
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi cập nhật điều khoản!')->error();

            return redirect()->back()->withInput();
        }
    }

    
    public function destroy($id)
    {
        try {
            $check = $this->policyService->destroy($id);
            if ($check) {
                flash('Xóa điều khoản thành công!')->success();
            } else {
                flash('Đã xảy ra lỗi khi xóa điều khoản!')->error();
            }
        } catch (Exception $e) {
            flash('Đã xảy ra lỗi khi xóa điều khoản!')->error();
        }
    }

    public function changeStatus($id) {
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
