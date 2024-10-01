<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
use App\Services\StatusService;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    protected $userService;

    protected $statusService;

    public function __construct(UserService $userService, StatusService $statusService)
    {
        $this->userService = $userService;
        $this->statusService = $statusService;
    }

    // Hiển thị tất cả người dùng
    public function index(Request $request)
    {

        $filters = [
            'search' => $request->input('search'),
            'status' => $request->input('status'),
            'gender' => $request->input('gender'),
        ];
        $users = $this->userService->filter($filters);

        return view('admin.customer.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::find($id);
        if (! $user) {
            flash('Không có người dùng tương ứng')->error();

            return back();
        }
        $province = Province::find($user->province_id);
        $province_name = $province ? $province->province_name : 'Không xác định';
        $district = District::find($user->district_id);
        $district_name = $district ? $district->district_name : 'Không xác định';
        $ward = Ward::find($user->ward_id);
        $ward_name = $ward ? $ward->ward_name : 'Không xác định';

        return view('admin.customer.show', compact('user', 'province_name', 'district_name', 'ward_name'));
    }

    public function create()
    {
        $provinces = Province::all();

        return view('admin.customer.create', compact('provinces'));
    }

    public function store(UserRequest $request)
    {
        try {
            $this->userService->store($request->all());
            flash('Thêm người dùng thành công')->success();

            return redirect()->route('admin.customer.index');
        } catch (\Exception $e) {
            flash('Thêm người dùng thất bại')->error();

            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $provinces = Province::all();
        $user = User::find($id);
        if (! $user) {
            flash('Không có người dùng tương ứng')->error();

            return back();
        }

        return view('admin.customer.edit', compact('user', 'provinces'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $this->userService->update($request->all(), $id);
            flash('Sửa người dùng thành công')->success();

            return redirect()->route('admin.customer.index', $id);
        } catch (QueryException $e) {
            flash('Sửa người dùng thất bại')->error();

            return redirect()->route('admin.customer.edit', $id);
        } catch (\Exception $e) {
            flash('Sửa người dùng thất bại')->error();

            return redirect()->route('admin.customer.edit', $id);
        }
    }

    public function destroy($id)
    {
        $result = $this->userService->destroy($id);
        if ($result) {
            flash('Xoá người dùng thành công')->success();

            return redirect()->route('admin.customer.index');
        } else {
            flash('Xoá người dùng thất bại')->error();

            return redirect()->route('admin.customer.index');
        }
    }

    public function changeStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            $this->statusService->changeStatus($user);
            flash('Thay đổi trạng thái thành công!')->success();

            return response()->json([
                'status' => '200',
                'message' => 'Sửa thông tin thành công.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => '500',
                'message' => 'Sửa thông tin thất bại.',
            ], 500);
        }
    }
}
