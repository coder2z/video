<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2019/3/8
 * Time: 13:09
 */

namespace App\Http\Middleware;


use Illuminate\Support\Facades\Auth;

class AdminToken
{
    public function handle($request, \Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->token == 1) {
                return $next($request);
            } else {
                return redirect('error');
            }
        } else {
            return redirect('error');
        }


    }

}