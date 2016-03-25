<?php namespace App\Http\Controllers\users;
use App\user;
use App\Doctor;
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

class UserProfileController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Users Profile Controller
	|--------------------------------------------------------------------------
	|
	| @author Michika Iranga Perera
	|
	| This class will handled the all user profile edits done by the users
	|
	*/
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('loginCheck');
	}
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$doctor=Session::get('doctor');
		if( is_null($doctor) ){
			return view('user.userprofile')->with('user',Session::get('user'));
		}else{
			return view('user.userprofile')->with('user',Session::get('user'))->with('doctor',$doctor);
		}	
		
	}
	/**
	*	Regular expressions testng function
	*	Input parameters are $value: The testing value
	*						 $type : What is the filter that we want to you use, For and example
	*								 If we want to test for and Email, parameter should be EMAIL
	*   @param  NIC(used for check National Identitiy card no, TP(used for check the Telephone numbers)
	*	@return true,false
	**/
	public function regex($value,$type)
	{
		if( $type=="NIC" ){
			if( preg_match("/^[0-9]{9}[v]{1}$/", $value) ){
				return true;
			}
		}elseif( $type=="TP" ){
			if( preg_match("/^[0-9]{9}$/", $value) ){
				return true;
			}
		}
		return false;
	}
	/**
	*	This will update the user session, it will update the users session object
	*
	*
	*/
	public function updateSession()
	{
		$user = user::where('id',Session::get('userid'))->first();
		Session::put('user',$user);
		if( $user->level==2 ){
			$doctor=Doctor::where('email','=',$user->email)->first();
			if( !is_null($doctor) ){
				Session::put('doctor', $doctor);
			}
		}
	}
	/**
	* Get all the JSON POST requests and process them
	* Tasks
	* 1. Upload the pictures and change the profile picture
	* 2. Change NIC
	* 3. Change Password
	* 4. Change Name
	* @return JSON Response
	*/
	public function inputs()
	{
		$user=Session::get('user');
			if( is_null($user) ){
				return response()->json(['message'=>'hacker']);
			}
		if( Request::get('formname')=="picture" ){
			/**
			*	Change the profile picture
			*
			*/
			if( Input::file('pic')->isValid() ){
					$allowed=array('gif','png' ,'jpg');
					$image=Input::file('pic');
					if($image->getSize()>614348){
						return  response()->json(['message' => 'File size is too large', 'code' => 'warning']);
					}
					if(!in_array($image->getClientOriginalExtension(),$allowed) ) {
    						return  response()->json(['message' => 'Please Upload an image', 'code' => 'error']);
					}
					$destinationPath = base_path() . '/../public/uploads/profile_pics';
					$fullPath = 'uploads/profile_pics/'.Session::get('userid').'.'.$image->getClientOriginalExtension();
        			if(!$image->move($destinationPath, Session::get('userid').'.'.$image->getClientOriginalExtension())) {
            			return  response()->json(['message' => 'Error saving the file', 'code' => 'error']);
        			}
        			$user->pic=$fullPath;
        			$user->save();
        			$this->updateSession();
				return response()->json(['message' => 'Profile picture updated!','filename'=>$fullPath,'code' => 'success']);
			}else{
				return  response()->json(['message' => 'Upload an different image', 'code' => 'error']);
			}
		}elseif( Request::get('formname')=="nicForm" ){
			/**
			*	Change the NIC
			*
			*/
			$nic = Request::get('nic');
			if($this->regex($nic,"NIC")){
				$checkUser = user::where('nic',$nic)->count();
				if($user->nic==$nic){
					return response()->json(['message'=>'NIC updated success!','code'=>'success']);
				}elseif($checkUser>0){
					return response()->json(['message'=>'NIC Already Taken','code'=>'error']);
				}
				$user->nic=$nic;
				$user->save();
				$this->updateSession();
				return response()->json(['message'=>'NIC updated success!','code'=>'success']);
			}else{
				return response()->json(['message'=>'Check your NIC!','code'=>'warning']);
			}
		}elseif( Request::get('formname')=="passwordForm" ){
			/**
			*	Change the User Password
			*
			*/
			$password=Request::get('password');
			if($password!=''){
				$user->password=md5($password);
				$user->save();
				$this->updateSession();
				return response()->json(['message'=>'Passowrd updated success!','code'=>'success']);
			}else{
				return response()->json(['message'=>'Check your Passowrd!','code'=>'warning']);
			}
		}elseif( Request::get('formname')=="nameForm" ){
			/**
			*	Change the User's Name
			*
			*/
			$name=Request::get('name');
			if($name!=''){
				$user->name=$name;
				$user->save();
				$this->updateSession();
				return response()->json(['message'=>'Name updated success!','code'=>'success']);
			}else{
				return response()->json(['message'=>'Check your Name!','code'=>'warning']);
			}
		}elseif( Request::get('formname')=="tpnoFormDoctor" ){
			/**
			*	Change the Doctors working no
			*
			*/
			$phoneNo=Request::get('tpnoWorking');
			$doctor=Session::get('doctor');
			if( $this->regex($phoneNo,"TP") || is_null($doctor) ){
				$doctor->phone=$phoneNo;
				$doctor->save();
				$this->updateSession();
				return response()->json(['message'=>'Working Phone Number updated success!','code'=>'success']);
			}else{
				return response()->json(['message'=>'Check your Phone Number!','code'=>'warning']);
			}
		}
	}
}
