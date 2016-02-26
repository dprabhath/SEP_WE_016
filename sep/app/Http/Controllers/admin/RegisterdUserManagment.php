<?php namespace App\Http\Controllers\admin;
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
class RegisterdUserManagment extends Controller {

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
		$this->middleware('AdminloginCheck');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = $user = Session::get('user');
		
		return view('admin/usermanage')->with('user',$user);
		
		//eturn view('admin/usermanage');
	}
	/**
	*
	*
	* Take all the GET Json Requset and do the task accouring to them
	* Tasks
	* 	1. Load the Registerd User table
	*	2. Load the Blocked Users table
	* 	3. Activate Users
	*	4. Deactivate Users
	*	5. Search
	*
	* @return JSON Response
	**/
	public function inputs(){

		$user = Session::get('user');
		if(is_null($user)){
			return  response()->json(['message' => ':3', 'code' => 'error']);
		}

		if(Request::get('task')=="loadtableRegisterd"){
			$user = user::where('active',1)->skip(0)->take(20)->get();
			$count = user::where('active',1)->count();
			
			return  response()->json(['users' => $user, 'code' => 'success' , 'task' => 'loadtableRegisterd', 'total' =>$count]);
		}elseif (Request::get('task')=="resetPassword") {
			
			$ids = Request::get('users');
			if(!is_null($ids)){


				foreach ($ids as &$value) {
					$user = user::find($value);
					if(!is_null($user)){

						$pass = Str::random(10);
						$user->password = md5($pass);
						$user->save();
						Mail::send('mailtemplate/passwordreset', ['name'=> $user->name,'pass'=>$pass], function ($m) use ($user) {
							$m->from('hello@app.com', 'Your Application');

							$m->to($user->email, $user->name)->subject('New Password!');
						});

					}else{
						return  response()->json(['message' => 'Users not passsed', 'code' => 'error']);
					}
				}



			}else{
				return  response()->json(['message' => 'pak u hacker', 'code' => 'error']);
			}

			return  response()->json(['code' => 'success' , 'task' => 'resetPassword']);

		}elseif (Request::get('task')=="loadtableBlocked") {
			$user = user::where('active',0)->skip(0)->take(20)->get();
			$count = user::where('active',0)->count();
			return  response()->json(['users' => $user, 'code' => 'success' , 'task' => 'loadtableBlocked','total' =>$count]);
		}elseif (Request::get('task')=="DeactivateUsers") {
			$ids = Request::get('users');
			if(!is_null($ids)){


				foreach ($ids as &$value) {
					$user = user::find($value);
					if($user->id==Session::get('userid')){
						continue;
					}
					$user->active = 0;
					$user->save();
					
				}



			}else{
				return  response()->json(['message' => 'pak u hacker', 'code' => 'error']);
			}

			return  response()->json(['code' => 'success' , 'task' => 'DeactivateUsers']);
		}elseif (Request::get('task')=="ActivateUsers") {
			$ids = Request::get('users');
			if(!is_null($ids)){


				foreach ($ids as &$value) {
					$user = user::find($value);
					$user->active = 1;
					$user->save();
				}



			}else{
				return  response()->json(['message' => 'pak u hacker', 'code' => 'error']);
			}

			return  response()->json(['code' => 'success' , 'task' => 'ActivateUsers']);

		}elseif(Request::get('task')=="search"){
			$user = null;
			$searchString = Request::get('searchString');
			if(Request::get('tasktype')==1){
				$user = user::where('active','1')->where('email', 'LIKE', "%$searchString%")->skip(0)->take(20)->get();
				$count = user::where('active','1')->where('email', 'LIKE', "%$searchString%")->count();
				return  response()->json(['users' => $user, 'code' => 'success' , 'task' => 'loadtableRegisterd','total' =>$count]);
			}else{
				$user = user::where('active','0')->where('email', 'LIKE', "%$searchString%")->skip(0)->take(20)->get();
				$count = user::where('active','0')->where('email', 'LIKE', "%$searchString%")->count();
				return  response()->json(['users' => $user, 'code' => 'success' , 'task' => 'loadtableBlocked','total' =>$count]);
			}
			
			
			
		}else{
			return  response()->json(['message' => 'hacker', 'code' => 'error']);
		}

		
	}
}