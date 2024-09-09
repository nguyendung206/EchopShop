<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;

class ProfileController extends Controller
{
    public function index($id)
    {
        $profile = Admin::where('id', $id)->first();

        return view('admin.profile', compact('profile'));
    }

    public function update(ProfileRequest $request)
    {
        $profile = Admin::find($request->id);

        if ($profile) {
            $profile->email = $request->email;
            $profile->name = $request->name;
            if ($request->hasFile('uploadPhoto')) {
                if ($profile->avatar && $profile->avatar !== 'default.png') {
                    deleteImage($profile->avatar, 'upload/employee');
                }
                $profile->avatar = uploadImage($request->file('uploadPhoto'), 'upload/employee');
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
