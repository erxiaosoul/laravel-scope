<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validator::make($request->input(), [
        //     "mobile" => ['required', new PhoneRule(), Rule::exists('users')],
        //     "captcha" => ['required', 'captcha']
        // ], ['captcha.captcha' => '验证码输入错误'])->validate();

        $user = User::where('email', $request->account)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::guard('web')->login($user);
            return $this->success('登录成功', ['token' => $user->createToken('auth')->plainTextToken, 'user' => $user]);
        }

        throw ValidationException::withMessages(['password' => '密码输入错误']);
    }
}
