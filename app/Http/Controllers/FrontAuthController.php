<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FrontAuthController extends Controller
{
    public function sendCode(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:191'],
        ]);

        $email = strtolower($data['email']);
        $code = (string) random_int(100000, 999999);

        $user = User::where('email', '=', $email, 'and')->first();

        if (! $user) {
            $user = new User();
            $user->email = $email;
            $user->phone = '';
            $user->name = $email;
            $user->password = Hash::make(Str::random(16));
            $user->state = 'pending';
            $user->balance = 0;
        }

        $user->token = $code;
        $user->state = 'pending';
        $user->save();

        // try {
        // 发送邮件通知管理员
        Mail::raw("你的邮箱验证码是：{$code}", function ($message) use ($email, $code) {
            $message->to($email)
                ->from('gongchi@yhwzkj.com', '元亨微阵技术团队')
                ->subject('【元亨微阵】邮箱验证码');
        });
        // } catch (\Throwable $e) {
        //     return $this->errorResponse('验证码发送失败，请稍后再试', 1);
        // }

        return $this->successResponse(null, '验证码已发送');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:191'],
            'code' => ['required', 'digits:6'],
            'password' => ['required', 'min:6', 'max:191'],
            'name' => ['nullable', 'string', 'max:191'],
        ]);

        $email = strtolower($data['email']);
        $user = User::where('email', '=', $email, 'and', 'and')->first();

        if (! $user) {
            return $this->errorResponse('请先发送验证码', 1);
        }

        if ($user->state === 'active' && $user->token === null) {
            return $this->errorResponse('该邮箱已注册，请直接登录', 1);
        }

        if ($user->token !== $data['code']) {
            return $this->errorResponse('验证码不正确', 1);
        }

        $user->name = ! empty($data['name']) ? $data['name'] : explode('@', $email)[0];
        $user->password = Hash::make($data['password']);
        $user->token = null;
        $user->state = 'active';
        $user->save();

        Auth::login($user);

        return $this->successResponse([
            'redirect' => route('orders.index'),
        ], '注册成功');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:191'],
            'password' => ['required', 'min:6', 'max:191'],
        ]);

        $user = User::where('email', '=', strtolower($data['email']), 'and')->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return $this->errorResponse('邮箱或密码错误', 1);
        }

        if ($user->state !== 'active') {
            return $this->errorResponse('账号尚未完成注册，请先完成注册', 1);
        }

        Auth::login($user);

        return $this->successResponse([
            'redirect' => route('orders.index'),
        ], '登录成功');
    }

    public function profile()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:191'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $avatarPath = $user->avatar;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user->fill([
            'name' => $data['name'] ?? $user->name,
            'avatar' => $avatarPath,
            'phone' => $data['phone'] ?? $user->phone,
        ]);
        $user->save();

        return redirect()->route('profile.edit')->with('success', '资料更新成功。');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
