<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Flash\Flash;

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
                return redirect()->back()->with('error', 'Email đã tồn tại. Vui lòng chọn email khác.');
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
            // \Spatie\Flash\Flash::levels([
            //     'success' => 'alert-success',
            //     'warning' => 'alert-warning',
            //     'error' => 'alert-error',
            // ]);
            // flash()->success('Hurray');
            // flash()->warning('Mayybeee');
            // flash()->error('Oh Oh');

            // flash('Cập nhật Hồ sơ thành công')->success();
            // return redirect()->route('profile.index', ['Id' => $request->Id]);
            return redirect()->route('profile.index', ['Id' => $request->Id])->with('message', 'Cập nhật Hồ sơ thành công');
        } else {
            return redirect()->back()->with('error', 'Profile không tồn tại.');
        }
    }
}
