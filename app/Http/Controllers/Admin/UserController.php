<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Users;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Http\Requests\UserRequest;
use App\Enums\UserGender;
use Laracasts\Flash\Flash;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct( UserService $userService)
    {
        $this->userService = $userService;
    }

    // Hiển thị tất cả người dùng
    public function index (Request $request) {
       
        $filters = [
            'search' => $request->input('search'),
            'status' => $request->input('status'),
            'gender' => $request->input('gender'),
        ];
        $users = $this->userService->filter($filters);
        return view('admin.userManager.index', compact('users'));
    }

    public function show($id) {
        $user = Users::find($id);
        if(!$user) {
            flash('Không có người dùng tương ứng')->error();
            return redirect()->route('manager-user.store');
        }
        $province= Province::find($user->province_id);
        $province_name = $province ? $province->province_name : 'Không xác định';
        $district = District::find($user->district_id);
        $district_name = $district ? $district->district_name : 'Không xác định';
        $ward = Ward::find($user->ward_id);
        $ward_name = $ward ? $ward->ward_name : 'Không xác định';
        return view('admin.userManager.show', compact('user', 'province_name','district_name','ward_name'));
    }

    public function create () {
        $provinces = Province::all();
        return view('admin.userManager.create', compact('provinces'));
    }

    public function store (UserRequest $request) {
        try {
                $userData = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone_number' => $request->phone_number,
                    'citizen_identification_number' => $request->citizen_identification_number,
                    'date_of_issue' => $request->date_of_issue,
                    'place_of_issue' => $request->place_of_issue,
                    'date_of_birth' => $request->date_of_birth,
                    'province_id' => $request->province_id,
                    'district_id' => $request->district_id,
                    'ward_id' => $request->ward_id,
                    'address' => $request->address,
                    'gender' => $request->gender,
                    'status' => $request->status,
                    'avatar' => uploadImage($request->file('uploadFile'), 'upload/users/', 'nophoto.png'),
                ];

                Users::create($userData);
                flash('Thêm người dùng thành công')->success();
                return redirect()->route('manager-user.create');
        } catch (QueryException $e) {
            flash('Thêm người dùng thất bại')->error();
            return redirect()->route('manager-user.create');
        } catch (\Exception $e) {
            flash('Thêm người dùng thất bại')->error();
            return redirect()->route('manager-user.create');
        }
    }


    public function edit($id) {
        $provinces = Province::all();
        $user = Users::find($id);
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        return view('admin.userManager.edit', compact('user','provinces'));
    }

    public function update (UserRequest $request ,$id) {
        $user = Users::find($id);
        if(!$user) {
            flash('Sửa thông tin thất bại')->error();
            return back();
        }
        $avatar = $user->avatar;
        try {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'citizen_identification_number' => $request->citizen_identification_number,
                'date_of_issue' => $request->date_of_issue,
                'place_of_issue' => $request->place_of_issue,
                'date_of_birth' => $request->date_of_birth,
                'province_id' => $request->province_id,
                'district_id' => $request->district_id,
                'ward_id' => $request->ward_id,
                'address' => $request->address,
                'gender' => $request->gender,
                'status' => $request->status,
                'avatar' => uploadImage($request->file('uploadFile'), 'upload/users/', $avatar),
            ];
            if($request->has('password') && !empty($request->password)) {
                $updateData['password'] = bcrypt($request->password);
            }

            $user->update($updateData);
            
            if($request->file('uploadFile')) {
                deleteImage($avatar);
            }

            flash('Sửa người dùng thành công')->success();
            return redirect()->route('manager-user.edit', $id);
        }  catch (QueryException $e) {
            flash('Sửa người dùng thất bại')->error();
            return redirect()->route('manager-user.edit',$id);
        } catch (\Exception $e) {
            flash('Sửa người dùng thất bại')->error();
            return redirect()->route('manager-user.edit', $id);
        }
    }

 
    public function destroy($id) {
        $user = Users::find($id);
        if(!$user) {
            flash('Không có người dùng tương ứng')->error();
            return back();
        }
        
        $result = $user->delete();
        deleteImage($user->avatar);
        if($result){
            flash('Xoá người dùng thành công')->success();
            return  redirect()->route('manager-user.index');
        }else {
            flash('Xoá người dùng thất bại')->error();
            return redirect()->route('manager-user.index');
        }
    }

    public function updateStatus (Request $request ,$id) {
        $user = Users::find($id);
        if(!$user) {
            flash('Sửa thông tin thất bại')->error();
            return back();
        }
        try {
            $updateData = [
                'status' => $request->status,
            ];
            $user->update($updateData);
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