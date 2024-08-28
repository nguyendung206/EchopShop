<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Users;
use App\Http\Requests\UserRequest;
use App\Enums\UserGender;
// use Spatie\Flash\Flash;
use Laracasts\Flash\Flash;
use App\Services\ImageService;
use App\Services\UserService;

class UserController extends Controller
{
    protected $imageService;
    protected $userService;

    public function __construct(ImageService $imageService, UserService $userService)
    {
        $this->imageService = $imageService;
        $this->userService = $userService;
    }

    // Hiển thị tất cả người dùng
    public function index (Request $request) {
       
        $filters = [
            'name' => $request->input('name'),
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
        return view('admin.userManager.show', compact('user'));
    }

    public function create () {
            return view('admin.userManager.create');
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
                    'address' => $request->address,
                    'gender' => $request->gender,
                    'status' => $request->status,
                    'avatar' => $this->imageService->uploadImage($request->file('uploadFile'), 'upload/users', 'nophoto.png'),
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
        $user = Users::find($id);
        if(!$user) {
            return back()->with('message', 'Không có người dùng tương ứng');
        }
        return view('admin.userManager.edit', compact('user'));
    }

    public function update (UserRequest $request ,$id) {
        $user = Users::find($id);
        if(!$user) {
            flash('Sửa thông tin thất bại')->error();
            return back();
        }
        
        try {
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
                'avatar' => $this->imageService->uploadImage($request->file('uploadFile'), 'upload/users', 'nophoto.png'),
            ];
            if($request->has('password') && !empty($request->password)) {
                $updateData['password'] = bcrypt($request->password);
            }

            $user->update($updateData);
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
        $this->imageService->deleteImage($user->avatar, 'upload/users','nophoto.png');
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
            flash('Sửa thông tin thành công')->success();
            return redirect()->route('manager-user.index',);
        }  catch (QueryException $e) {
            flash('Sửa thông tin thất bại')->error();
            return redirect()->route('manager-user.index');
        } catch (\Exception $e) {
            flash('Sửa thông tin thất bại')->error();
            return redirect()->route('manager-user.edit', $id);
        }
    }
}