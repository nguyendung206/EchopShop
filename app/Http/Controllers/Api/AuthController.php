<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiEmailRequest;
use App\Http\Requests\ApiResetPasswordRequest;
use App\Jobs\SendForgotPasswordMail;
use App\Models\ResetPasswordToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (! Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Lỗi xác thực',
                ]);
            }

            $user = User::where('email', $request->email)->first();

            if (! Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Lỗi đăng nhập');
            }
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ], 200);

        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Lỗi đăng nhập',
                'error' => $error,
            ]);
        }
    }

    public function me(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Đăng xuất thành công',
        ], 200);
    }

    public function forgotPassword(ApiEmailRequest $request)
    {
        // try {

        $user = User::where('email', $request->email)->first();
        $token = \Str::random(40);
        $pin = rand(100000, 999999);
        $tokenData = [
            'email' => $request->email,
            'token' => $token,
            'pin' => $pin,
        ];
        if (ResetPasswordToken::where('email', $request->email)->exists()) {
            ResetPasswordToken::where('email', $request->email)->update(['token' => $token, 'pin' => $pin]); // update token mới nếu đã có email trong database

            $emailJob = new SendForgotPasswordMail($user, $token, $pin, $user->email);
            dispatch($emailJob);
        } else {
            ResetPasswordToken::create($tokenData);
            $emailJob = new SendForgotPasswordMail($user, $token, $pin, $user->email);
            dispatch($emailJob);
        }

        return response()->json([
            'success' => true,
            'email' => $user->email,
            'token_data' => $token,
            'pin' => $pin,
            'url_reset_password' => URL::temporarySignedRoute('api.resetPassword', now()->addMinute(10), ['token' => $token]),
        ], 200);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Lỗi server',
        //         'error' => $e,
        //     ], 500);
        // }
    }

    public function checkPinCodeAndResetPassword(ApiResetPasswordRequest $request, $token)
    {
        try {
            $checkToken = ResetPasswordToken::where('token', $token)->first();
            $checkPin = ResetPasswordToken::where('token', $token)->where('pin', $request->pin)->first();
            if ($checkPin) {
                $timeDifference = Carbon::now()->diffInMinutes($checkPin->updated_at);
                if ($timeDifference > 3) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Mã pin của bạn đã hết hạn vui lòng gửi lại email.',
                    ], 404);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Đổi mật khẩu thành công.',
                ], 200);
            }

            $responseJson = [
                'success' => false,
            ];
            if (! $checkToken) {
                $responseJson['message'] = 'Đường dẫn không hợp lệ.';
            }
            if (! $checkPin) {
                $responseJson['message'] = 'Bạn đã nhập sai mã PIN vui lòng thử lại.';
            }

            return response()->json($responseJson, 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi server',
                'error' => $e,
            ], 500);
        }

    }
}
