<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2019/3/8
 * Time: 13:09
 */

namespace App\Http\Middleware;


use Illuminate\Support\Facades\Auth;

class GiveAToken
{
    public function handle($request, \Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        } else {
            return redirect('error');
        }

    }

}