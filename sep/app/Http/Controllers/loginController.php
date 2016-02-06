<?php namespace App\Http\Controllers;

use App\user;
use Mail;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Redirect;
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
		//$users = user::all();
		//return $users;
		//Session::put('userid', 1);
		$user = user::where('id',Session::get('userid'))->first();
		if(is_null($user)){
				return view('login');
		}else{
				return Redirect::to('home');
		}
		return view('login');
	}


	/**
	*	Regular expressions testng function
	*	Input parameters are $value: The testing value
	*						 $type : What is the filter that we want to you use, For and example
	*								 If we want to test for and Email, parameter should be EMAIL
	*   @param EMAIL(used for check email addresses, TP(used for check the Telephone numbers)
	*	@return true,false
	**/
	public function regex($value,$type){
		if($type=="EMAIL"){
			if(preg_match("/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/", $value)){
				return true;
			}
		}elseif($type=="TP"){
			if(preg_match("/^[0-9]{10}$/", $value)){
				return true;
			}
		}

		return false;

	}


	/**
	* Take All JSON Post Requset and process them
	*  Tasks
	*	 1. Reset Passwords
	*	 2. Login
	*	 3. Send Emails when Password is resetted
	*
	* @return Response, Views
	**/
	public function inputs()
	{


		if(Request::get('formname')=="reset"){

			$email = Request::get('email');
			$user=null;
			if($this->regex($email,"TP")){
				$user = user::where('tp',$email)->first();
			}elseif ($this->regex($email,"EMAIL")) {
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
				$user->password = md5($pass);
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


		}elseif(Request::get('formname')=="loginFrom"){
			$email = Request::get('email_login');
			$password = md5(Request::get('password_login'));

			$user=null;
			if ($this->regex($email,"EMAIL")) {
				# code...
				$user = user::where('email',$email)->where('password','=',$password)->where('active','=',1)->first();
			}

			if(is_null($user)){
				return view('login')->with('fail',1);
			}else{
				
				Session::put('userid', $user->id);
				return Redirect::to('home');

			}
		}else{
			return view('login');
		}

		return view('login');
	}

	/**
	* Initiate the logout of the user
	**/
	public function signout(){
		Session::flush();
		return Redirect::to('home');
	}
}