<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\EmailRequest;
use Laracasts\Flash\Flash;
use App\Models\Users;
use App\Models\District;
use App\Models\Ward;
use App\Models\Province;
use App\Models\ResetPasswordToken;
use  App\Mail\ForgotPasswordMail;
use Mail;

class AuthController extends Controller
{   

    

    public function index(Request $request) {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('web.auth.login');
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
        if (Auth::check()) {
            return redirect('/');
        }
        $provinces = Province::all();

        return view('web.auth.register', compact('provinces'));
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
                    'avatar' => uploadImage($request->file('uploadFile'), 'upload/users', 'nophoto.png'),
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

    // Trang quên mật khẩu
    public function forgotPassword() {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('web.auth.forgotPassword');
    }

    // Gửi mail 
    public function handleForgotPassword(EmailRequest $request) {

        $user = Users::where('email', $request->email)->first();
        $token = \Str::random(40);
        $pin = rand(100000, 999999);
        $tokenData = [
            'email' => $request->email,
            'token' => $token,
            'pin' => $pin,
        ];
        if(ResetPasswordToken::where('email',$request->email)->exists()) {
            ResetPasswordToken::where('email', $request->email)->update(['token' => $token, 'pin' => $pin]); // update token mới nếu đã có email trong database
            Mail::to($request->email)->send(new ForgotPasswordMail($user, $token, $pin));
        }else{
            ResetPasswordToken::create($tokenData);
            Mail::to($request->email)->send(new ForgotPasswordMail($user, $token, $pin));
        }
        flash('Đã gửi tin nhắn đến mail của bạn vui lòng kiểm tra mail')->success();
        return back();
    }


    // Hiển thị trang nhập PIN
    public function indexPinAuthentication($token) {
        $tokenData = ResetPasswordToken::where('token', $token)->firstOrFail();
        $email = $tokenData->email;
        return view('web.auth.pinCode', compact('token', 'email'));
    }
    // Kiểm tra PIN, đúng sẽ chuyển vào trang đổi mật khẩu
    public function checkPinCode(Request $request, $token) {
        $request->validate([
            'pin' => ['required', 'digits:6']
        ]);
        $tokenData = ResetPasswordToken::where('token', $token)->firstOrFail();
        $pin = $request->pin;
        $checkPin = ResetPasswordToken::where('pin', $pin)->exists();
        if($checkPin){
            return view('web.auth.resetPassword', compact('token'));
        }
        return back()->with('error','Bạn đã nhập sai mã PIN vui lòng thử lại.');
    }
    // Xửa lý đổi mật khẩu
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
        $tokenNew = \Str::random(40);
        $pinNew = rand(100000, 999999);
        ResetPasswordToken::where('token', $token)->update(['token' => $tokenNew,'pin' => $pinNew]); // Đổi lại token sau khi update thành công (form dùng 1 lần)
        return redirect()->route('web.login');
    }
}
