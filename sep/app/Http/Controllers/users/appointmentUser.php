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
use Carbon\Carbon;
class appointmentUser extends Controller {

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
		 $this->middleware('loginCheck');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Views
	 */
	public function index()
	{
		
		
	}

	/**
	*
	* show the available slots for spefic doctor
	* @return view
	*/
	public function show($id){
		$doctor=null;
		$userRequested=null;
		$doctor=Doctor::where('id',$id)->first();
		if( !is_null($doctor) ){
			$userRequested=user::where('email','=',$doctor->email)->first();
			if( !is_null($userRequested) ){
				return view('user.appointmetns.place')->with('user',Session::get('user'))->with('userReq',$userRequested)->with('doctor',$doctor);
			}
		}
		return view('user.appointmetns.place')->with('user',Session::get('user'));
	}

}
