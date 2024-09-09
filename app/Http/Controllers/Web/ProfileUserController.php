<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Province;
use App\Models\User;
use App\Models\Users;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProfileUserController extends Controller
{
    public function index($id)
    {
        $profile = Users::where('id', $id)->first();
        $provinces = Province::all();
        return view('web.profile', compact('profile', 'provinces'));
    }

    public function update(UserRequest $request)
    {
        $profile = Users::findOrFail($request->id);
        if ($profile) {
            $profile->email = $request->email;
            $profile->name = $request->name;
            $profile->phone_number = $request->phone_number;
            $profile->address = $request->address;
            $profile->province_id = $request->province_id;
            $profile->district_id = $request->district_id;
            $profile->ward_id = $request->ward_id;
            $profile->citizen_identification_number = $request->citizen_identification_number;
            $profile->date_of_issue = $request->date_of_issue;
            $profile->place_of_issue = $request->place_of_issue;
            $profile->gender = $request->gender;
            $profile->date_of_birth = $request->date_of_birth;

            if ($request->hasFile('avatar')) {
                if ($profile->avatar && $profile->avatar !== 'nophoto.png') {
                    deleteImage($profile->avatar, 'upload/users');
                }

                $profile->avatar = uploadImage($request->file('avatar'), 'upload/users');
            }

            if ($request->hasFile('identification_image')) {
                if ($profile->identification_image && $profile->avatar !== 'nophoto.png') {
                    deleteImage($profile->identification_image, 'upload/users');
                }
                $profile->identification_image = uploadImage($request->file('identification_image'), 'upload/users');
            }
            $profile->save();

            return redirect()->route('web.profile.index', ['id' => $request->id])
                ->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy hồ sơ.');
        }
    }
}
