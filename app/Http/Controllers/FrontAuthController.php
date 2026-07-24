<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FrontAuthController extends Controller
{
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = strtolower($request->email);
        $code = (string) random_int(100000, 999999);

        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = new User();
            $user->email = $email;
            $user->phone = '';
            $user->name = $email;
            $user->password = Hash::make(Str::random(16));
            $user->token = $code;
            $user->state = 'pending';
            $user->balance = 0;
            $user->save();
        } else {
            $user->token = $code;
            $user->state = 'pending';
            $user->save();
        }

        // 先用邮件发送占位，后续你可真实接 SMTP
        Mail::raw("你的邮箱验证码是：{$code}", function ($message) use ($email) {
            $message->to($email)->subject('智作·快反邮箱验证码');
        });

        return response()->json([
            'code' => 0,
            'message' => '验证码已发送',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6'],
            'password' => ['required', 'min:6'],
            'name' => ['nullable', 'string', 'max:191'],
        ]);

        $email = strtolower($request->email);

        $user = User::where('email', $email)->first();

        if (! $user) {
            return response()->json(['code' => 1, 'message' => '请先发送验证码'], 422);
        }

        if ($user->token !== $request->code) {
            return response()->json(['code' => 1, 'message' => '验证码不正确'], 422);
        }

        $user->name = $request->name ?? $email;
        $user->password = Hash::make($request->password);
        $user->token = null;
        $user->state = 'active';
        $user->save();

        Auth::login($user);

        return response()->json([
            'code' => 0,
            'message' => '注册成功',
            'redirect' => route('orders.index'),
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        $user = User::where('email', strtolower($request->email))->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['code' => 1, 'message' => '邮箱或密码错误'], 422);
        }

        Auth::login($user);

        return response()->json([
            'code' => 0,
            'message' => '登录成功',
            'redirect' => route('orders.index'),
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('products.index');
    }
}