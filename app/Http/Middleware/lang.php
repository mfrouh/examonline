<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App;
class lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    if (Auth::check())
    {
        if (!Auth::user()->lang) {
            $user=Auth::user();
            $user->lang='en';
            $user->save();
            App::setLocale(Auth::user()->lang);
        }
        else
        {
            Auth::user()->lang;
            App::setLocale(Auth::user()->lang);
        }
    }
    else
    {
       if(session()->get('lang')){
         App::setLocale(session()->get('lang'));
       }
       else
       {
        session()->put('lang','en');
        App::setLocale(session()->get('lang'));
       }
    }
        return $next($request);
    }
}
