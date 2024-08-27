<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;
use Laracasts\Flash\Flash;

class ProfileController extends Controller
{
    public function Index($id)
    {
        $profile = Admin::where('id', $id)->first();
        return view('admin.profile', compact('profile'));
    }

    public function Save(ProfileRequest $request)
    {
        $profile = Admin::where('id', $request->id)->first();
        if ($profile) {
            $profile->email = $request->email;
            $profile->name = $request->name;
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
