<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    // Hiển thị tất cả người dùng
    public function index () {
            $users = Users::all();
            return view('admin.userManager.index', compact('users'));
    }

    public function show($id = null) {
        if(empty($id)) {
            $users = Users::all();
            return view('admin.userManager.index', compact('users'));
        }
        $user = Users::find($id);
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        return view('admin.userManager.show', compact('user'));
    }

    public function create () {
            return view('admin.userManager.create');
    }

    public function store (UserRequest $request) {
            
            $request->day_of_issue = \DateTime::createFromFormat('d/m/Y', $request->input('day_of_issue'))->format('Y-m-d');
            $request->date_of_birth = \DateTime::createFromFormat('d/m/Y', $request->input('date_of_birth'))->format('Y-m-d');
            Users::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone_number' => $request->phone_number,
                'citizen_identification_number' => $request->citizen_identification_number,
                'day_of_issue' => $request->day_of_issue,
                'place_of_issue' => $request->place_of_issue,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'gender' => $request->gender,
                'status' => $request->status,
            ]);
            return redirect()->route('manager-user.index');
    }


    public function edit($id = null) {
        $user = Users::find($id);
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        return view('admin.userManager.edit', compact('user'));
    }

    public function update (Request $request ,$id = null) {
        $user = Users::find($id);
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        $request->day_of_issue = \DateTime::createFromFormat('d/m/Y', $request->input('day_of_issue'))->format('Y-m-d');
        $request->date_of_birth = \DateTime::createFromFormat('d/m/Y', $request->input('date_of_birth'))->format('Y-m-d');
        $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'citizen_identification_number' => $request->citizen_identification_number,
                'day_of_issue' => $request->day_of_issue,
                'place_of_issue' => $request->place_of_issue,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'gender' => $request->gender,
                'status' => $request->status,
        ]);
        return redirect()->route('manager-user.index');
    }

 
    public function destroy($id) {
        $user = Users::find($id);
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        
        $result = $user->delete();
        if($result){
            return redirect()->route('manager-user.index');
        }else {
            return redirect()->route('manager-user.index')->with('message', 'Xoá người dùng thất bại');
        }
    }
}