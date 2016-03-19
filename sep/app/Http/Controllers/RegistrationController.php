<?php namespace App\Http\Controllers;

use App\user;
use Mail;
use Illuminate\Support\Str;
use Session;
use Illuminate\Support\Facades\Redirect;
use Arcanedev\NoCaptcha\NoCaptcha;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
//use Illuminate\http\Request;
use Request;
class RegistrationController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| User Registration Controller
	|--------------------------------------------------------------------------
	|
	| @author Michika Iranga Perera
	|
	| This class will handled the Users Registraion process
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
	public function regex($value,$type)
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
	*	This function will verify the email address for the new Registration
	*	@param string $email email
	*	@return Json Response
	*/
	private function checkEmail($email)
	{
		if( !is_null($email) ){
			if( $this->regex($email,"EMAIL") ){
				$checkUser=user::where('email',$email)->count();
				if( $checkUser==0 ){
					return  response()->json(['message' => 'Ok', 'code' => 'success' ,'task' => 'checkEmail']);
				}else{
					return  response()->json(['message' => 'Email already Registerd', 'code' => 'error' ,'task' => 'checkEmail']);
				}
			}
		}
		return  response()->json(['message' => 'Email Verification failed', 'code' => 'error' ,'task' => 'checkEmail']);
	}
	/**
	*	This function will verify the phone number for the new Registration
	*	@param string $phone phone
	*	@return Json Response
	*/
	private function checkPhone($phone)
	{
		if( !is_null($phone) ){
			if( $this->regex($phone,"TP") ){
				$phone="+94".$phone;
				$checkUser=user::where('tp',$phone)->count();
				if($checkUser==0){
					return  response()->json(['message' => 'Ok', 'code' => 'success' ,'task' => 'checkPhone']);
				}else{
					return  response()->json(['message' => 'Phone Number already Registerd', 'code' => 'error' ,'task' => 'checkPhone']);
				}
			}
		}
		return  response()->json(['message' => 'Phone Number Verification failed', 'code' => 'error' ,'task' => 'checkPhone']);
	}
	/**
	* Take All JSON Post Requset and process them
	*  Tasks
	*	 1. 
	*
	* @return Response, Views
	**/
	public function inputs()
	{
		if( Request::get('task')=="checkEmail" ){
			$email=Request::get('email');
			return $this->checkEmail($email);
		}elseif( Request::get('task')=="checkPhone" ){
			$phone="";
			$phone=Request::get('phone');
			return $this->checkPhone($phone);
		}elseif( Request::get('task')=="submit" ){
			/**
			*
			* Handled the main Registraion form submission
			*
			*/
			$phone=Request::get('txtPhone');
			$email=Request::get('txtEmail');
			$password=Request::get('txtPassword');
			$nic=Request::get('txtNIC');
			if( is_null($phone) || is_null($email) || is_null($password) ){
				return view('registration')->with('email',$email)->with('phone',$phone)->with('nic',$nic);
			}
			$phoneVerify=json_decode($this->checkPhone($phone)->getContent(),true);
			$emailVerify=json_decode($this->checkEmail($email)->getContent(),true);
			if( $phoneVerify['code']=="error" || $emailVerify['code']=="error" ){
				return view('registration')->with('email',$email)->with('phone',$phone)->with('nic',$nic);
			}
			$inputs=Input::all();
			$rules=[
    			// Other validation rules...
			'g-recaptcha-response' => 'required|captcha',
			];
			$messages=[
			'g-recaptcha-response.required' => 'You Must Fill the Captcha',
			'g-recaptcha-response.captcha'  => 'Captcha Error',
			];
			$validator=Validator::make($inputs, $rules, $messages);
			if ( $validator->fails() ) {
				$errors=$validator->messages();
				return view('registration')->with('email',$email)->with('phone',$phone)->with('nic',$nic)->with('captcha','Captcha Erro');
			}
			$newUser=new user;
			$newUser->email=$email;
			if( !is_null($nic) ){
				$newUser->nic=$nic;
			}
			$newUser->password=md5($password);
			$phone="+94".$phone;
			$newUser->tp=$phone;
			$newUser->level="1";
			$newUser->active=1;
			$newUser->verified=0;
			$newUser->save();
			Session::put('loginMsg','user_created');
			return Redirect::to('login');
		}
	}
}