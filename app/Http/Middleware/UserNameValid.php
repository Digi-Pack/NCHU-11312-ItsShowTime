<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserNameValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response

    {
        
        $item = Auth::user();

        if ($item && $item->name === 'YZ') {
            // dd($next($request));
            return redirect()->route('dashboard');
        } else {
            return $next($request);
            // dd('dd');
            return redirect()->route('myprofile');
        }


        // // 取得當前登入的使用者
        // $user = Auth::user();

        // // 如果使用者是 YZ，繼續讓請求通過
        // if ($user && $user->name === 'YZ') {
        //     return $next($request);
        // }

        // // 如果不是 YZ，重導向到首頁
        // return redirect('myprofile');
    }
}
