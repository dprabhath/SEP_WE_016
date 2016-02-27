<?php namespace App\Http\Controllers;

use App\user;
use Mail;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Redirect;
//use Illuminate\http\Request;
use Request;
class registrationController extends Controller {

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
				return view('registration');
		}else{
			return Redirect::to('home');
		}
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
			if(preg_match("/^[0-9]{9}$/", $value)){
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


		if(Request::get('task')=="checkEmail")
		{
			$email = Request::get('email');
			if(!is_null($email)){
				if($this->regex($email,"EMAIL")){
					$checkUser = user::where('email',$email)->count();
					if($checkUser==0){
						return  response()->json(['message' => 'Ok', 'code' => 'success' ,'task' => 'checkEmail']);
					}else{
						return  response()->json(['message' => 'Email already Registerd', 'code' => 'error' ,'task' => 'checkEmail']);
					}
				}
			}
			return  response()->json(['message' => 'Email Verification failed', 'code' => 'error' ,'task' => 'checkEmail']);
		}
	}

	
	
}