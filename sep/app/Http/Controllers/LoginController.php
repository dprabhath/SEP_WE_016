<?php namespace App\Http\Controllers;

use App\user;
use Mail;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Redirect;
//use Illuminate\http\Request;
use Request;
class LoginController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| @author Michika Iranga Perera
	|
	| This will handled the users login,signout,Rcover Account
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
		$user=user::where('id',Session::get('userid'))->first();
		if( is_null($user) ){
			if( !is_null(Session::get('loginMsg')) ){
				return view('login')->with('msg','complete');
			}else{
				return view('login');
			}
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
	private function regex($value,$type)
	{
		if( $type=="EMAIL" ){
			if(preg_match("/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/", $value)){
				return true;
			}
		}elseif( $type=="TP" ){

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
		$user=user::where('id',Session::get('userid'))->first();
		if( !is_null($user) ){
			return Redirect::to('home');
		}
		if( Request::get('formname')=="reset" ){
			/**
			*
			*	Account Recovery
			*
			*/
			$email=Request::get('email');
			$user=null;
			if($this->regex($email,"TP")){
				$user=user::where('tp',"+94".$email)->first();
			}elseif($this->regex($email,"EMAIL")){
				$user=user::where('email',$email)->first();
			}else{
				return "notfound";
			}
			if(is_null($user)){
				return "notfound";
			}else{
				$pass=Str::random(10);
				$user->password=md5($pass);
				if($user->save()){
					Mail::send('mailtemplate/passwordreset', ['name'=> $user->name,'pass'=>$pass], function ($m) use ($user) {
						$m->from('daemon@mail.altairsl.us', 'Daemon');
						$m->to($user->email, $user->name)->subject('New Password!');
					});
					return "Check the Email Settings or your internet connection";
				}else{
					return "Check the Email Settings or your internet connection";
				}
			}
		}elseif( Request::get('formname')=="loginFrom" ){
			/**
			*
			*	User Login
			*
			*/
			$email=Request::get('email_login');
			$password=md5(Request::get('password_login'));
			$user=null;
			if( $this->regex($email,"EMAIL") ){
				$user=user::where('email',$email)->where('password','=',$password)->where('active','=',1)->first();
			}elseif ($this->regex($email,"TP")) {
				$user=user::where('tp',"+94".$email)->where('password','=',$password)->where('active','=',1)->first();
			}
			if( is_null($user) ){
				return view('login')->with('fail',1);
			}else{
				Session::put('userid', $user->id);
				Session::put('user',$user);
				if( is_null(Session::get('url')) ){
					return Redirect::to('home');
				}else{
					//return Session::get('url');
					return Redirect::to(Session::get('url'));
					//die();
				}
			}
		}else{
			return view('login');
		}
		return view('login');
	}
	/**
	* Initiate the logout of the user
	**/
	public function signout()
	{
		Session::flush();
		session_start();
		unset($_SESSION['access_token']);
		unset($_SESSION['OAuth_email']);
		unset($_SESSION['OAuth_name']);
		return Redirect::to('home');
	}
	/**
	* Take the response from the Google Auth and process it
	**/
	public function gauth()
	{
		$user=user::where('id',Session::get('userid'))->first();
		if( !is_null($user) ){
			return Redirect::to('home');
		}
		session_start();
		if( isset($_SESSION['OAuth_email']) ){
			$userEmail=$_SESSION['OAuth_email'];
			$user=user::where('email',$userEmail)->first();
			if( is_null($user) ){
				$newUser=new user;
				$newUser->email=$userEmail;
				$pass=Str::random(10);
				$newUser->password=md5($pass);
				if( isset($_SESSION['OAuth_name']) ){
					$newUser->name=$_SESSION['OAuth_name'];
				}else{
					$newUser->name="User";
				}
				$newUser->level="1";
				$newUser->active=1;
				$newUser->verified=0;
				if( $newUser->save() ){
					Mail::send('mailtemplate/sociallogin', ['name'=> $newUser->name,'pass'=>$pass], function ($m) use ($newUser) {
						$m->from('daemon@mail.altairsl.us', 'Daemon');
						$m->to($newUser->email, $newUser->name)->subject('New Password!');
					});
					//return "Check the Email Settings or your internet connection";
				}else{
					return "Check the Email Settings or your internet connection";
				}
				Session::put('userid', $newUser->id);
				Session::put('user',$newUser);
				return Redirect::to('profile');
			}else{
				if( $user->active==0 ){
					Session::flush();
					unset($_SESSION['access_token']);
					unset($_SESSION['OAuth_email']);
					unset($_SESSION['OAuth_name']);
					return Redirect::to('login');
				}	
				Session::put('userid', $user->id);
				Session::put('user',$user);
				if( is_null(Session::get('url')) ){
					return Redirect::to('home');
				}else{
					return Redirect::to(Session::get('url'));
				}
			}
		}else{
				Session::flush();
				unset($_SESSION['access_token']);
				unset($_SESSION['OAuth_email']);
				unset($_SESSION['OAuth_name']);
				return Redirect::to('login');
		}
	}
}