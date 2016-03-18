<?php namespace App\Http\Middleware;
use App\user;
use Mail;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Redirect;
use Closure;
use Request;
class adminLogins {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		$url = $request->path();
		Session::put('url',$url);
		
		if(is_null(Session::get('userid')) || is_null(Session::get('user'))){
			return Redirect::to('login');
		}else{

			$user = Session::get('user');
			if($user->verified==0){
				return Redirect::to('verify');
			}
			if($url=="admin/usermanage"){

				if($user->level<10){
					Session::flush();
					return Redirect::to('login');
				}else{
					return $next($request);
				}

			}else{
				if($user->level<5){
					Session::flush();
					return Redirect::to('login');
				}else{
					return $next($request);
				}
			}
			
			
		}

	}


}
