<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdentificationRequest;
use App\Http\Requests\ProfileUserRequest;
use App\Models\Province;
use App\Models\ShippingAddress;
use App\Models\User;
use App\Services\FavoriteService;
use App\Services\ShippingAddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileUserController extends Controller
{
    protected $favoriteService;

    protected $shippingAddressService;

    public function __construct(FavoriteService $favoriteService, ShippingAddressService $shippingAddressService)
    {
        $this->favoriteService = $favoriteService;

        $this->shippingAddressService = $shippingAddressService;
    }

    public function index(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $user['province_id'] = $user->defaultAddress ? $user->defaultAddress->province->id : null;
        $user['district_id'] = $user->defaultAddress ? $user->defaultAddress->district->id : null;
        $user['ward_id'] = $user->defaultAddress ? $user->defaultAddress->ward->id : null;
        $user['address'] = $user->defaultAddress ? $user->defaultAddress->street : null;
        $provinces = Province::all();

        $favorites = $this->favoriteService->getProduct(9);
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

            if ($request->hasFile('avatar')) {
                if ($profile->avatar && $profile->avatar !== 'nophoto.png') {
                    deleteImage($profile->avatar, 'upload/users');
                }

                $profile->avatar = uploadImage($request->file('avatar'), 'upload/users/');
            }

            $profile->save();

            return redirect()->route('profile.index', ['id' => $request->id])
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

            return redirect()->route('profile.index', ['id' => $request->id])
                ->with('success', 'Cập nhật thông tin thành công!');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy hồ sơ.');
        }
    }

    public function getAddress(Request $request)
    {
        try {
            $addresses = ShippingAddress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

            return view('web.profile.address', compact('addresses'));
        } catch (\Throwable $th) {
            return false;
        }

    }

    public function updateDefault($id)
    {
        try {
            $this->shippingAddressService->updateDefault($id);

            return redirect()->back()->with('success', 'Cập nhật địa chỉ thành công');
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteAddress($id)
    {
        try {
            $check = $this->shippingAddressService->destroy($id);
            if ($check) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Xoá địa chỉ thành công.',
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Xoá địa chỉ thất bại.',
                ], 500);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Xoá địa chỉ thất bại.',
            ], 500);
        }
    }
}
