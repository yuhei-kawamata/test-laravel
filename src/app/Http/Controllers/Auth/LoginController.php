<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ログインフォームを表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 登録しているメールアドレスとパスワードが一致したらログイン可能
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // セッションIDを再生成することでセッション固定攻撃を防ぐ
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            /*
            intended(route('tasks.index'))
            ①ログインしていないとアクセスできないURLに入ろうとする
            ②ログイン画面に飛ばされる
            ③ログインする
            ④ ①でアクセスしようとしていたURLにアクセスされる（intended()の効果）
            ※①がない場合は、'tasks.index'にアクセスされる
            */ 
            return redirect()->intended(route('tasks.index'))
                ->with('success', 'ログインしました！');
        }

        // emailだけ入力された内容が残るように定義（ユーザーエクスペリエンス向上）
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ])->onlyInput('email');
    }
}
