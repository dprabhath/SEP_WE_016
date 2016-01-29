<?php namespace App\Http\Controllers;

use App\user;
use Mail;
use Illuminate\Support\Str;
//use Illuminate\http\Request;
use Request;
class loginController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = user::all();
		//return $users;
		return view('login');
	}
	
	public function inputs()
	{


		if(Request::get('formname')=="reset"){

			$email = Request::get('email');
			$user=null;
			if(preg_match("/^[0-9]{10}$/", $email)){
				$user = user::where('tp',$email)->first();
			}elseif (preg_match("/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/", $email)) {
				# code...
				$user = user::where('email',$email)->first();
			}else{
				return "notfound";
			}

			//$user = user::where('tp',$email)->first();



			if(is_null($user)){
				return "notfound";
			}else{
				$pass = Str::random(10);
				$user->password = $pass;
				if($user->save()){
/*
				Mail::raw($pass, function ($m) use ($user) {
					$m->from('hello@app.com', 'Your Application');

					$m->to($user->email, $user->name)->subject('Your New Password!');
				});
*/
					Mail::send('mailtemplate/passwordreset', ['name'=> $user->name,'pass'=>$pass], function ($m) use ($user) {
						$m->from('hello@app.com', 'Your Application');

						$m->to($user->email, $user->name)->subject('New Password!');
					});


					return "ok";
				}else{
					return "erro";


				}
			}
		}


	}
}