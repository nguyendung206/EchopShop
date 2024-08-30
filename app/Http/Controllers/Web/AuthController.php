<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\EmailRequest;
use Laracasts\Flash\Flash;
use App\Services\UploadImageService;
use App\Models\Users;
use App\Models\District;
use App\Models\Ward;
use App\Models\Province;
use App\Models\ResetPasswordToken;
use  App\Mail\ForgotPasswordMail;
use Mail;

class AuthController extends Controller
{   
    protected $uploadImageService;

    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
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
                    'avatar' => $this->uploadImageService->uploadImage($request->file('uploadFile'), 'upload/users', 'nophoto.png'),
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

    public function forgotPassword() {
        return view('web.forgotPassword');
    }

    public function handleForgotPassword(EmailRequest $request) {

        $user = Users::where('email', $request->email)->first();
        $token = \Str::random(40);
        $tokenData = [
            'email' => $request->email,
            'token' => $token
        ];
        if(ResetPasswordToken::where('email',$request->email)->exists()) {
            ResetPasswordToken::where('email', $request->email)->update(['token' => $token]); // update token mới nếu đã có email trong database
            Mail::to('chiendeptrai2002@gmail.com')->send(new ForgotPasswordMail($user, $token));
        }else{
            ResetPasswordToken::create($tokenData);
            Mail::to('chiendeptrai2002@gmail.com')->send(new ForgotPasswordMail($user, $token));
        }
        flash('Đã gửi tin nhắn đến mail của bạn vui lòng kiểm tra mail')->success();
        return back();
    }

    public function resetPassword(Request $request ,$token) {
        $tokenData = ResetPasswordToken::where('token', $token)->firstOrFail();
        return view('web.resetPassword', compact('token'));
    }

    public function handleResetPassword(Request $request, $token) {
        $request->validate([
            'password' => ['required', 'min:3', 'max:255'],
            'passwordConfirm' => ['required', 'same:password'],
        ]);
        $tokenData = ResetPasswordToken::where('token', $token)->firstOrFail();
        $user = Users::where('email', $tokenData->email)->firstOrFail();
        $data = [
            'password' => bcrypt($request->password),
        ];
        $user->update($data);
        $tokenChange = \Str::random(40);
        ResetPasswordToken::where('token', $token)->update(['token' => $tokenChange]); // Đổi lại token sau khi update thành công (form dùng 1 lần)
        return redirect()->route('web.login');
    }
}
