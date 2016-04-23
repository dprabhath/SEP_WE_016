<?php namespace App\Http\Controllers\apis;
//use App\user;
//use App\cronResetPassword;
//use App\deletedUser;
//use App\disabledUser;
//use Mail;
use App\Doctor;
use Illuminate\Support\Str;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
//use Illuminate\Http\Request;
use Input;
use Validator;
use Request;
class api extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');

	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * Api for the application
	 * 
	 * @return Json response
	 */
	public function index()
	{
		if( Request::get('task')=="doctorCity" ){

				$city=Request::get('city');

				if(is_null($city)){
					return  response()->json(['message' => 'you should pass the paramater city', 'code' => 'error']);
				}

				$doctors=null;
				$doctors=Doctor::where('city', 'LIKE', "%$city%")->select('first_name', 'last_name','specialization','hospital','phone')->get();

				return  response()->json(['doctors' => $doctors, 'code' => 'ok']);
		}elseif( Request::get('task')=="doctorspecialization" ){
			$specialization=Request::get('specialization');

			if(is_null($specialization)){
				return  response()->json(['message' => 'you should pass the paramater specialization', 'code' => 'error']);
			}
			$doctors=null;
			$doctors=Doctor::where('specialization', 'LIKE', "%$specialization%")->select('first_name', 'last_name','specialization','hospital','phone')->get();

			return  response()->json(['doctors' => $doctors, 'code' => 'ok']);

		}elseif( Request::get('task')=="doctorhospital" ){
			$hospital=Request::get('hospital');

			if(is_null($hospital)){
				return  response()->json(['message' => 'you should pass the paramater hospital', 'code' => 'error']);
			}
			$doctors=null;
			$doctors=Doctor::where('hospital', 'LIKE', "%$hospital%")->select('first_name', 'last_name','specialization','hospital','phone')->get();

			return  response()->json(['doctors' => $doctors, 'code' => 'ok']);

		}else{
			return  response()->json(['message' => 'you should pass the paramater task', 'code' => 'error']);
		}

	}

}