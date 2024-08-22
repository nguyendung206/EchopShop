<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUserManagerController extends Controller
{
    // Hiển thị tất cả người dùng
    public function listUsers (Request $request) {
        $users = DB::table('users')->get();
        return view('admin.userManager.userManager', compact('users'));
    }

    // Hiển thị user được chọn theo id
    public function getUser ($id) {
        $user = DB::table('users')->where('id', $id)->first();
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        return view('admin.userManager.getUser', compact('user'));
    }

    // Hiển thị form thêm user
    public function addUserForm (Request $request) {
        return view('admin.userManager.addUserForm');
    }

    // Xử lý thêm user
    public function handleAddUser (Request $request) {
        if(empty($request->name) || empty($request->email) || empty($request->password) 
            || empty($request->phone_number) || empty($request->citizen_identification_number) 
                || empty($request->place_of_issue) || empty($request->address)) {
                    return back()->with('message', 'Vui lòng nhập đầy đủ thông tin')->withInput();
        }
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'citizen_identification_number' => $request->citizen_identification_number,
            // 'day_of_issue' => $request->day_of_issue,
            'place_of_issue' => $request->place_of_issue,
            // 'date_of_birth' => $request->email,
            'address' => $request->address,
        ]);
        return redirect()->route('list.user');
    }

    // Hiển thị form sửa user
    public function updateUser($id) {
        $user = DB::table('users')->where('id', $id)->first();
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        return view('admin.userManager.updateUserForm', compact('user'));
    }

    // Xử lý sửa thông tin người dùng
    public function handleUpdateUser(Request $request, $id) {
        $user = DB::table('users')->where('id', $id)->first();
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        if(empty($request->name) || empty($request->email)
            || empty($request->phone_number) || empty($request->citizen_identification_number) 
                || empty($request->place_of_issue) || empty($request->address)) {
                    return back()->with('message', 'Vui lòng nhập đầy đủ thông tin')->withInput();
        }
        DB::table('users')->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'citizen_identification_number' => $request->citizen_identification_number,
            // 'day_of_issue' => $request->day_of_issue,
            'place_of_issue' => $request->place_of_issue,
            // 'date_of_birth' => $request->email,
            'address' => $request->address,
        ]);
        return redirect()->route('list.user');
    }

    // xoá người dùng
    public function deleteUser($id) {
        $user = DB::table('users')->where('id', $id)->first();
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        
        $result =DB::table('users')->where('id', $id)->delete();
        if($result == 1 ){
            return redirect()->route('list.user');
        }else {
            return redirect()->route('list.user')->with('message', 'Xoá người dùng thất bại');
        }
    }


}
