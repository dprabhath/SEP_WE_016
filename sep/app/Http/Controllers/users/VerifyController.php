<?php namespace App\Http\Controllers\users;
use App\user;
use Mail;
use Illuminate\Support\Str;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
//use Illuminate\Http\Request;
use Input;
use Validator;
use Request;
class VerifyController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Verify Account Controller
	|--------------------------------------------------------------------------
	|
	| @author Michika Iranga Perera
	|
	| This controller will handled the account verification after the registration
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
		if( is_null(Session::get('emailKey')) ){
			Session::put('emailKey',rand(10000, 99999));
		}
		if( is_null(Session::get('phoneKey')) ){
			Session::put('phoneKey',rand(99999, 999999));
		}
		$user=Session::get('user');
		$phone=$user->tp;
		$phone=substr($phone, 3);
		if( !is_null($user) && $user->verified==0 ){
			return view('user.verify')->with('user',$user)->with('phone',$phone);
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
		$user=Session::get('user');
		if( Request::get('task')=="sendEmail" ){
			/**
			*
			*	Send the Email including the activation code
			*
			*/
			$email=Request::get('email');
			if( is_null($email) ){
				return  response()->json(['message' => 'Missmatch Data', 'code' => 'error' ,'task' => 'sendEmail']);
			}
			if( $user->email != $email ){
				$checkUser=user::where('email',$email)->count();
				if( $checkUser==0 ){
					$user->email=$email;
				}else{
					return  response()->json(['message' => 'Email already Registerd', 'code' => 'error' ,'task' => 'checkEmail']);
				}
			}
			Mail::send('mailtemplate/emailVerify', ['name'=> $user->name,'code'=>Session::get('emailKey')], function ($m) use ($user) {
				$m->from('hello@app.com', 'Your Application');

				$m->to($user->email, $user->name)->subject('Confirmation Code');
			});
			$user->save();
			Session::put('user',$user);
			return  response()->json(['message' => 'Ok', 'code' => 'success' ,'task' => 'sendEmail']);
			
		}elseif( Request::get('task')=="sendPhone" ){
			/**
			*
			*	Send the MMS including the activation code
			*
			*/
			$phone=Request::get('phone');
			if( is_null($phone) ){
				return  response()->json(['message' => 'Missmatch Data', 'code' => 'error' ,'task' => 'sendPhone']);
			}
			$phone="+94".$phone;
			if( $user->tp!=$phone ){
				$checkUser=user::where('tp',$phone)->count();
				if( $checkUser==0 ){
					$user->tp=$phone;
				}else{
					return  response()->json(['message' => 'phone already Registerd', 'code' => 'error' ,'task' => 'sendPhone']);
				}
			}
			$code=Session::get('phoneKey');
			Mail::send('mailtemplate/emailVerify', ['name'=> $user->name,'code'=>Session::get('phoneKey')], function ($m) use ($user,$phone,$code) {
				$m->from('hello@app.com', 'Your Application');

				$m->to($phone."@mms.dialog.lk", $user->name)->subject($code);
			});
			$user->save();
			Session::put('user',$user);
			return  response()->json(['message' => 'Ok', 'code' => 'success' ,'task' => 'sendPhone']);

		}elseif( Request::get('task')=="verify" ){
			/**
			*
			*	Finalized the registration by comparing activation codes
			*
			*/
			$codePhone=Request::get('codePhone');
			$codeEmail=Request::get('codeEmail');
			if( Session::get('phoneKey')==$codePhone && Session::get('emailKey')==$codeEmail ){
				$user->verified=1;
				$user->save();
				Session::flush();
				return  response()->json(['message' => 'Ok', 'code' => 'success' ,'task' => 'verify']);
			}else{
				return  response()->json(['message' => 'Codes Missmatch', 'code' => 'error' ,'task' => 'verify']);
			}
		}
	}
	
}