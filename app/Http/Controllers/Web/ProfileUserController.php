<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdentificationRequest;
use App\Http\Requests\ProfileUserRequest;
use App\Models\Province;
use App\Models\User;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class ProfileUserController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function index(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $provinces = Province::all();

        $favorites = $this->favoriteService->getProduct(8);
        if ($request->ajax() || $request->wantsJson()) {
            $productHtml = view('web.moreFavorite', compact('favorites'))->render();
            $hasMorePage = ! $favorites->hasMorePages();

            return response()->json([
                'posts' => $productHtml,
                'hasMorePage' => $hasMorePage,
            ]);
        }

        return view('web.profile.profile', compact('user', 'provinces', 'favorites'));
    }

    public function updateProfile(ProfileUserRequest $request)
    {
        $profile = User::findOrFail($request->id);
        if ($profile) {
            $profile->email = $request->email;
            $profile->name = $request->name;
            $profile->phone_number = $request->phone_number;
            $profile->address = $request->address;
            $profile->province_id = $request->province_id;
            $profile->district_id = $request->district_id;
            $profile->ward_id = $request->ward_id;

            if ($request->hasFile('avatar')) {
                if ($profile->avatar && $profile->avatar !== 'nophoto.png') {
                    deleteImage($profile->avatar, 'upload/users');
                }

                $profile->avatar = uploadImage($request->file('avatar'), 'upload/users/');
            }

            $profile->save();

            return redirect()->route('web.profile.index', ['id' => $request->id])
                ->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy hồ sơ.');
        }
    }

    public function updateIdentification(IdentificationRequest $request)
    {
        $profile = User::findOrFail($request->id);
        if ($profile) {
            $profile->citizen_identification_number = $request->citizen_identification_number;
            $profile->date_of_issue = $request->date_of_issue;
            $profile->place_of_issue = $request->place_of_issue;
            $profile->gender = $request->gender;
            $profile->date_of_birth = $request->date_of_birth;

            if ($request->hasFile('identification_image')) {
                if ($profile->identification_image && $profile->avatar !== 'nophoto.png') {
                    deleteImage($profile->identification_image, 'upload/users');
                }
                $profile->identification_image = uploadImage($request->file('identification_image'), 'upload/users/');
            }
            $profile->save();

            return redirect()->route('web.profile.index', ['id' => $request->id])
                ->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy hồ sơ.');
        }
    }
}
