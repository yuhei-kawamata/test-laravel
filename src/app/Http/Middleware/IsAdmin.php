<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ログインしていなければ、ログイン画面を表示
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 管理者権限がなければ、アクセス不可
        if (!auth()->user()->isAdmin()) {
            abort(403, 'このページにアクセスする権限がありません。');
        }
        
        return $next($request);
    }
}
