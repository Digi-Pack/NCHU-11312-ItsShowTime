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

        // return $next($request);
        $item = Auth::user();

        if (!$item || $item->name !== 'YZ') {
            // dd($item);
            return redirect()->route('myprofile');
        } else {
            // dd('cc');
            return redirect()->route('dashboard');
            // return $next($request);
        }


        // $item = Auth::user();

        // if (!$item || $item->name !== 'YZ') {
        //     // dd($item);
        //     return redirect()->route('myprofile');
        // } else {
        //     // 
        //     return redirect()->route('dashboard');
        // }


        // $item = Auth::user();

        // if ($item && $item->name === 'YZ') {
        //     // dd($next($request));
        //     return redirect()->route('dashboard');
        //     // return $next($request);
        // } else {
        //     // dd('dd');
        //     return redirect()->route('myprofile');
        // }


    }
}
