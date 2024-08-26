<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ProfileController extends Controller
{
    public function Index($id)
    {
        $profile = Admin::where('id', $id)->first();
        return view('admin.profile', compact('profile'));
    }

    public function Save(Request $request)
    {
        $profile = Admin::where('id', $request->id)->first();
        if ($profile) {
            if (empty($request->Name)) {
                flash('Tên không được để trống.')->error();
                return redirect()->back()->withInput();
            }
            $emailExists = Admin::where('email', $request->Email)
                ->where('id', '!=', $request->id)
                ->exists();
            if ($emailExists) {
                flash('Email đã tồn tại. Vui lòng chọn email khác.')->error();
                return redirect()->back();
            }
            $profile->email = $request->Email;
            $profile->name = $request->Name;
            if ($request->hasFile('uploadPhoto')) {
                $file = $request->file('uploadPhoto');
                $ext = $file->getClientOriginalExtension();
                $file_name = time() . '-' . 'employee.' . $ext;
                $file->move(public_path('upload/employee'), $file_name);
                $profile->avatar = $file_name;
            }
            $profile->save();
            flash('Cập nhật thông tin thành công!')->success();
            return redirect()->route('profile.index', ['id' => $request->id]);
        } else {
            flash('Không tìm thấy hồ sơ.')->error();
            return redirect()->back();
        }
    }
}
