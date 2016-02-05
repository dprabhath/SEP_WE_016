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
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('admin/usermanage');
	}

	public function registerdUsers(){
		

		//return view('admin/usermanage')->with('id',1);
	}

	public function view()
	{
		
		//return view('admin/usermanage');
	}
	public function inputs(){
		if(Request::get('task')=="loadtableRegisterd"){
			$user = user::where('active','1')->get();
			return  response()->json(['users' => $user, 'code' => 'success' , 'task' => 'loadtableRegisterd']);
		}elseif (Request::get('task')=="resetPassword") {
			
			$ids = Request::get('users');
			if(!is_null($ids)){


				foreach ($ids as &$value) {
    					$user = user::find($value);
    					if(!is_null($user)){

    							$pass = Str::random(10);
								$user->password = $pass;
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
			$user = user::where('active',0)->get();
			return  response()->json(['users' => $user, 'code' => 'success' , 'task' => 'loadtableBlocked']);
		}elseif (Request::get('task')=="DeactivateUsers") {
			$ids = Request::get('users');
			if(!is_null($ids)){


				foreach ($ids as &$value) {
    					$user = user::find($value);
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
		}else{
			return  response()->json(['message' => 'pak u hacker', 'code' => 'error']);
		}

		
	}
}