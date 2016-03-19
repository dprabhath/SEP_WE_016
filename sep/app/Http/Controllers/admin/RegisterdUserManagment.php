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
class RegisterdUserManagment extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Registerd users management Controller
	|--------------------------------------------------------------------------
	| @author Michika Iranga Perera 
	|
	| This class will handle the registered Users Profile Infromation
	| Such as User activation,Deactivation
	| 
	| 
	|
	*/
	private $resultCount=10; //store the number of row count for each page
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
		$user=Session::get('user');
		
		return view('admin/userManage')->with('user',$user);
		
		//eturn view('admin/usermanage');
	}
	/**
	*
	* Get the active registered users
	* 
	* @param get the pagination number
	* @return Json Response
	*
	*/
	private function loadTableRegisterd($skiper)
	{
		$user=user::where('active',1)->where('verified','=',1)->skip($this->resultCount*$skiper)->take($this->resultCount)->get();
		$count=user::where('active',1)->where('verified','=',1)->count();
		return  response()->json(['users' => $user, 'code' => 'success' , 'task' => 'loadtableRegisterd', 'total' =>$count,'skips' =>$this->resultCount]);
	}
	/**
	*
	* Reset the passwords of users
	* @param list $ids Users ids
	* @return Json Response
	*
	*/
	private function resetPassword($ids)
	{
		if( !is_null($ids) ){
				foreach( $ids as &$value ){
					$user=user::find($value);
					if( !is_null($user) ){
						$pass=Str::random(10);
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
	}
	/**
	*
	* Get the blocked the users
	* 
	* @param get the pagination number
	* @return Json Response
	*
	*/
	private function loadTableBlocked($skiper)
	{
		$user=user::where('active',0)->where('verified','=',1)->skip($this->resultCount*$skiper)->take($this->resultCount)->get();
		$count=user::where('active',0)->where('verified','=',1)->count();
		return  response()->json(['users' => $user, 'code' => 'success' , 'task' => 'loadtableBlocked','total' =>$count,'skips' =>$this->resultCount]);
	}
	/**
	*
	* Deactivate the registered users
	* @param list $ids Users ids
	* @return Json Response
	*
	*/
	private function deactivaeUsers($ids)
	{
		if( !is_null($ids) ){
				foreach ($ids as &$value) {
					$user = user::find($value);
					if($user->id==Session::get('userid')){
						continue;
					}
					$user->active = 0;
					$user->save();
				}
			}else{
				return  response()->json(['message' => 'Unauthorized Access', 'code' => 'error']);
			}
			return  response()->json(['code' => 'success' , 'task' => 'DeactivateUsers']);
	}
	/**
	*
	* Activate the registered users
	* @param list $ids Users ids
	* @return Json Response
	*
	*/
	private function activateUsers($ids)
	{
		if( !is_null($ids) ){
				foreach ($ids as &$value) {
					$user = user::find($value);
					$user->active = 1;
					$user->save();
				}
			}else{
				return  response()->json(['message' => 'pak u hacker', 'code' => 'error']);
			}

			return  response()->json(['code' => 'success' , 'task' => 'ActivateUsers']);
	}
	/**
	*
	* Search the users according to the type
	* @param String $searchstring what to search
	* @param Integer $tasktype what type of search
	* @return Json Response
	*
	*/
	private function search($searchString,$tasktype)
	{
		$user=null;
		if( $tasktype==1 ){
				$user=user::where('active','1')->where('email', 'LIKE', "%$searchString%")->skip(0)->take(20)->get();
				$count=user::where('active','1')->where('email', 'LIKE', "%$searchString%")->count();
				return  response()->json(['users' => $user, 'code' => 'success' , 'task' => 'loadtableRegisterd','total' =>$count]);
			}else{
				$user=user::where('active','0')->where('email', 'LIKE', "%$searchString%")->skip(0)->take(20)->get();
				$count=user::where('active','0')->where('email', 'LIKE', "%$searchString%")->count();
				return  response()->json(['users' => $user, 'code' => 'success' , 'task' => 'loadtableBlocked','total' =>$count]);
			}
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
	public function inputs()
	{
		$user=Session::get('user');
		if( is_null($user) ){
			return  response()->json(['message' => ':3', 'code' => 'error']);
		}
		if( Request::get('task')=="loadtableRegisterd" ){
			$x=Request::get('skip');
			return $this->loadTableRegisterd($x);
		}elseif( Request::get('task')=="resetPassword" ){
			$ids=Request::get('users');
			return $this->resetPassword($ids);
		}elseif( Request::get('task')=="loadtableBlocked" ){
			$x=Request::get('skip');
			return $this->loadTableBlocked($x);
		}elseif( Request::get('task')=="DeactivateUsers" ){
			$ids=Request::get('users');
			return $this->deactivaeUsers($ids);
		}elseif( Request::get('task')=="ActivateUsers" ){
			$ids=Request::get('users');
			return $this->activateUsers($ids);
		}elseif( Request::get('task')=="search" ){
			$searchString=Request::get('searchString');
			$tasktype = Request::get('tasktype');
			return $this->search($searchString,$tasktype);
		}else{
			return  response()->json(['message' => 'hacker', 'code' => 'error']);
		}
	}
}
