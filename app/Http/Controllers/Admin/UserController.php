<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Users;
use App\Http\Requests\UserRequest;
use App\Enums\UserGender;

class UserController extends Controller
{
    // Hiển thị tất cả người dùng
    public function index () {
            $users = Users::paginate(5);
            return view('admin.userManager.index', compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function show($id) {
        $user = Users::find($id);
        echo $user->gender;
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        return view('admin.userManager.show', compact('user'));
    }

    public function create () {
            return view('admin.userManager.create');
    }

    public function store (UserRequest $request) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone_number' => $request->phone_number,
                'citizen_identification_number' => $request->citizen_identification_number,
                'date_of_issue' => $request->date_of_issue,
                'place_of_issue' => $request->place_of_issue,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'gender' => $request->gender,
                'status' => $request->status,
            ];

            if ($request->hasFile('uploadFile')) {
            $file = $request->file('uploadFile');
            $ext = $file->getClientOriginalExtension();
            $file_name = time() . '-' . 'user.' . $ext;
            $file->move(public_path('upload/users'), $file_name);
            $userData['avatar'] = $file_name;
            }
            Users::create($userData);
            return redirect()->route('manager-user.create')-> with('message', 'Thêm người dùng thành công');
    }


    public function edit($id) {
        $user = Users::find($id);
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        return view('admin.userManager.edit', compact('user'));
    }

    public function update (UserRequest $request ,$id) {
        $user = Users::find($id);
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'citizen_identification_number' => $request->citizen_identification_number,
            'date_of_issue' => $request->date_of_issue,
            'place_of_issue' => $request->place_of_issue,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'gender' => $request->gender,
            'status' => $request->status,
        ];
        if ($request->hasFile('uploadFile')) {
            $file = $request->file('uploadFile');
            $ext = $file->getClientOriginalExtension();
            $file_name = time() . '-' . 'user.' . $ext;
            $file->move(public_path('upload/users'), $file_name);
            $updateData['avatar'] = $file_name;
        }
        $user->update($updateData);
        return redirect()->route('manager-user.edit', $id)-> with('message', 'Sửa người dùng thành công');
    }

 
    public function destroy($id) {
        $user = Users::find($id);
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        
        $result = $user->delete();
        if($result){
            return  response()->json(['message' => 'Xóa thành công'], 200);
        }else {
            return response()->json(['message' => 'Xóa người dùng thất bại'], 500);
        }
    }
}