<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->status != 1){
                return redirect('/')->with(['error'=>1, 'mgs'=>'Sorry! Your Account is blocked!']);
            }
            if(Auth::user()->verified != 1){
                return redirect('/')->with(['error'=>1, 'mgs'=>'Please Verify Your Account.']);
            }
            return $next($request);
        }else{
            session()->put('redirectUrl', url()->full());
            return redirect('/login');
        }
    }
}
