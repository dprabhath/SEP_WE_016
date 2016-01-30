<?php namespace App\Http\Controllers;
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
class UsrProfileController extends Controller {

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
			$user = user::where('id',Session::get('userid'))->first();
			if(is_null($user)){
				return Redirect::to('login');
			}else{
				return view('userprofile')->with('user',$user);
			}
			
			
		
		
		
		//return $value;
	}
	public function inputs(){
		$user = user::where('id',Session::get('userid'))->first();
			if(is_null($user)){
				return response()->json(['message'=>'pak you hacker']);
			}
		//return  response()->json(['message' => 'File size is too large', 'code' => 'warning']);
		$user = user::where('id',Session::get('userid'))->first();
		if(Request::get('formname')=="picture"){
			if(Input::file('pic')->isValid()){

					$allowed =  array('gif','png' ,'jpg');
					$image = Input::file('pic');
					if($image->getSize()>614348){
						return  response()->json(['message' => 'File size is too large', 'code' => 'warning']);
					}
					
					if(!in_array($image->getClientOriginalExtension(),$allowed) ) {
    						return  response()->json(['message' => 'Please Upload an image', 'code' => 'error']);
					}
					$destinationPath = base_path() . '/../public/uploads/profile_pics';
					$fullpath = 'uploads/profile_pics/'.Session::get('userid').'.'.$image->getClientOriginalExtension();
        			if(!$image->move($destinationPath, Session::get('userid').'.'.$image->getClientOriginalExtension())) {
            			return  response()->json(['message' => 'Error saving the file.', 'code' => 'error']);
        			}

        			$user->pic=$fullpath;
        			$user->save();
				return response()->json(['message' => 'Profile picture updated!','filename'=>$fullpath,'code' => 'success']);;
			}
			
        	
		}
	}

}