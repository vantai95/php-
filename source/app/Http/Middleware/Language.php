<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
Use App, Session, Carbon;
class Language {

    public function __construct(Application $app, Request $request) {
        $this->app = $app;
        $this->request = $request;
        $lang = Session::get ('locale');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->app->setLocale(session('locale', config('app.locale')));
        if (Session::has('locale') == true) {
            App::setLocale(Session::get('locale'));
        }else{
            session('locale', config('app.locale'));
            Session::put('locale',config('app.locale'));
            App::setLocale(Session::get('locale'));
        }
        
        return $next($request);
    }

}