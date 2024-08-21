<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ProfileController extends Controller
{
    public function Index($Id)
    {
        $profile = Admin::where('id', $Id)->first();
        return view('admin.profile', compact('profile'));
    }

    public function Save(Request $request)
    {
        $profile = Admin::where('id', $request->Id)->first();
        if ($profile) {
            $emailExists = Admin::where('email', $request->Email)
                ->where('id', '!=', $request->Id)
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
            return redirect()->route('profile.index', ['Id' => $request->Id]);
        } else {
            flash('Không tìm thấy hồ sơ.')->error();
            return redirect()->back();
        }
    }
}
