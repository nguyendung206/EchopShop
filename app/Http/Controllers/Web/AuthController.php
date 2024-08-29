<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RegisterRequest;
use Laracasts\Flash\Flash;
use App\Services\ImageService;
use App\Models\Users;
use App\Models\District;
use App\Models\Ward;
use App\Models\Province;

class AuthController extends Controller
{   
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request) {
        if (session()->has('user')) {
            return redirect('/');
        }
        return view('web.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            Session::put('user', $user);
            return redirect('/');
        } else {
            return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng.');
        }
    }

    public function register() {
        $provinces = Province::all();

        return view('web.register', compact('provinces'));
    }

    public function store (RegisterRequest $request) {
        try {
                $userData = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'province_id' => $request->province_id,
                    'district_id' => $request->district_id,
                    'ward_id' => $request->ward_id,
                    'avatar' => $this->imageService->uploadImage($request->file('uploadFile'), 'upload/users', 'nophoto.png'),
                ];

                Users::create($userData);
                $request->session()->regenerate();
                $user = Auth::user();
                Session::put('user', $user);
                flash('Đăng ký thành công')->success();
                return redirect('/');
        } catch (QueryException $e) {
            flash('Đăng ký thất bại')->error();
            return redirect()->route('web.register');
        } catch (\Exception $e) {
            flash('Đăng ký thất bại')->error();
            return redirect()->route('web.register');
        }
    }

    public function getDistrict(Request $request) {
        $districts = District::where('province_id', $request->provinceId)->get();
        return response()->json([
            'status' => 'success',
            'districts' => $districts,
            'message' => 'Danh sách quận huyện'
        ], 200);
    }

    public function getWard(Request $request) {
        $wards = Ward::where('district_id', $request->districtId)->get();
        return response()->json([
            'status' => 'success',
            'wards' => $wards,
            'message' => 'Danh sách phường xã'
        ], 200);
    }
}
