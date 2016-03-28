<?php namespace App\Http\Controllers\users;
use App\User;
use App\smslimit;
use Mail;
use SMS;
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
	* SMS sending function
	*
	* @return void
	*/
	private function sendsms($text,$destination)
	{
		$username = 'pbaf5haq'; 
    	$password = 'FbgBp3V2';
    	$source = 'Native Physican';
    	$content =  'action=sendsms'. 
                '&user='.rawurlencode($username). 
                '&password='.rawurlencode($password). 
                '&to='.rawurlencode($destination). 
                '&from='.rawurlencode($source). 
                '&text='.rawurlencode($text); 
     
    	$smsglobal_response = file_get_contents('http://www.smsglobal.com/http-api.php?'.$content); 
	}
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
		if( !is_null($user) && $user->verified==0 ){
			$phone=$user->tp;
			$phone=substr($phone, 3);
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
		if( is_null($user) || $user->verified==1 ){
			return response()->json(['message' => 'Missmatch Data', 'code' => 'error']);
		}
		if( Request::get('task')=="sendEmail" ){
			/**
			*
			*	Send the Email including the activation code
			*
			*/
			$email=Request::get('email');
			if( is_null($email) || trim($email) =="" || !preg_match("/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/", $email) ){
				return  response()->json(['message' => 'Missmatch Data', 'code' => 'error' ,'task' => 'sendEmail']);
			}
			if( $user->email != $email ){
				$checkUser=user::where('email',$email)->count();
				if( $checkUser==0 ){
					$user->email=$email;
				}else{
					return  response()->json(['message' => 'Email already Registerd', 'code' => 'error' ,'task' => 'sendEmail']);
				}
			}
			Mail::send('mailtemplate/emailVerify', ['name'=> $user->name,'code'=>Session::get('emailKey')], function ($m) use ($user) {
				$m->from('hello@app.com', 'Your Application');

				$m->to($user->email, $user->name)->subject('Confirmation Code');
			});
			$user->save();
			Session::put('user',$user);
			return  response()->json(['message' => 'Ok', 'code' => 'success' ,'task' => 'sendEmail','email' => $email]);
			
		}elseif( Request::get('task')=="sendPhone" ){
			/**
			*
			*	Send the MMS including the activation code
			*
			*/
			$smsLimit=smslimit::where('uid','=',Session::get('userid'))->first();
			if( is_null($smsLimit) ){
				$smsLimit=new smslimit;
				$smsLimit->uid=Session::get('userid');
				$smsLimit->count=1;
				$smsLimit->save();
			}else{
				if($smsLimit->count>=2){
					return  response()->json(['message' => 'you can only sent 2 SMS within a Day', 'code' => 'error' ,'task' => 'sendPhone']);
				}else{
					$smsCount=$smsLimit->count;
					$smsCount++;
					$smsLimit->count=$smsCount;
					$smsLimit->save();
				}
			}
			$phone=Request::get('phone');
			if( is_null($phone) || trim($phone) =="" || !preg_match("/^[0-9]{9}$/", $phone)){
				return  response()->json(['message' => 'Check your Phone number', 'code' => 'error' ,'task' => 'sendPhone']);
			}
			$phone="+94".$phone;
			if( $user->tp!=trim($phone) ){
				$checkUser=user::where('tp',$phone)->count();
				if( $checkUser==0 ){
					$user->tp=trim($phone);
				}else{
					return  response()->json(['message' => 'phone already Registerd', 'code' => 'error' ,'task' => 'sendPhone']);
				}
			}
			$code=Session::get('phoneKey');
			$user->save();
			Session::put('user',$user);
			SMS::queue('Your Confirmation Code is: '.$code, [], function($sms) use ($phone) {
    			$sms->to($phone);
			});
			//$this->sendsms('Your Confirmation Code is: '.$code,$phone);
			/*
			Mail::send('mailtemplate/emailVerify', ['name'=> $user->name,'code'=>Session::get('phoneKey')], function ($m) use ($user,$phone,$code) {
				$m->from('hello@app.com', 'Your Application');

				$m->to($phone."@mms.dialog.lk", $user->name)->subject($code);
			});
			*/
			
			return  response()->json(['message' => 'Ok', 'code' => 'success' ,'task' => 'sendPhone','phone' => $phone]);

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