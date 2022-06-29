<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function getLocale(){
        $request = Request();
        $uri = $request->path();
        $segmentsURI = explode('/', $uri);
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], config('app.locales'))){
            return $segmentsURI[0];
        }
        return null;
    }

    public function handle(Request $request, Closure $next)
    {
        $uri = $request->path();
        $locale = self::getLocale();
        if ($locale) {
            App::setLocale($locale);
            Cookie::queue('lang', $locale, 500000);
        }
        else {
            $lang = null;
            if (Cookie::get('lang')){
               $lang = Crypt::decrypt(Cookie::get('lang'), false);
               $lang = explode('|', $lang)[1];
            }
            else {
                $lang = config('app.locale');
            }
            $redirectTo = '/'.$lang.'/'.$uri;
            return redirect($redirectTo);
        }
        return $next($request);
    }
}
