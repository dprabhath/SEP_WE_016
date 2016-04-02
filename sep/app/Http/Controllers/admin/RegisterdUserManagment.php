<?php namespace App\Http\Controllers\admin;
use App\user;
use App\cronResetPassword;
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
		
		return view('admin/usermanage')->with('user',$user);
		
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
	* Get the pendig users who are not confirmed their account verification
	*
	* @param get the pagination number
	* @return Json Response
	*
	*/
	private function loadTablePending($skiper)
	{
		$user=user::where('verified',0)->skip($this->resultCount*$skiper)->take($this->resultCount)->get();
		$count=user::where('verified',0)->count();
		return  response()->json(['users' => $user, 'code' => 'success' , 'task' => 'loadtablePending', 'total' =>$count,'skips' =>$this->resultCount]);
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
						$newMailCron=new cronResetPassword;
						$pass=Str::random(10);
						$user->password = md5($pass);
						$user->save();
						$newMailCron->name=$user->name;
						$newMailCron->email=$user->email;
						$newMailCron->password=$pass;
						$newMailCron->save();
						//Mail::send('mailtemplate/passwordreset', ['name'=> $user->name,'pass'=>$pass], function ($m) use ($user) {
						//	$m->from('hello@app.com', 'Your Application');
						//	$m->to($user->email, $user->name)->subject('New Password!');
						//});
					}else{
						return  response()->json(['message' => 'Users not passsed', 'code' => 'error']);
					}
				}
			}else{
				return  response()->json(['message' => 'hacker', 'code' => 'error']);
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
	* Confirm Users
	* @param lists $ids Users Ids
	* @return Json Response
	*/
	private function confirmUsers($ids)
	{
		if( !is_null($ids) ){
				foreach ($ids as &$value) {
					$user = user::find($value);
					$user->verified=1;
					$user->save();
				}
			}else{
				return  response()->json(['message' => 'hacker', 'code' => 'error']);
			}

			return  response()->json(['code' => 'success' , 'task' => 'ConfirmUsers']);
	}
	/**
	*
	* Delete Users
	* @param lists $ids Users Ids
	* @return Json Response
	*/
	private function deleteUsers($ids)
	{
		if( !is_null($ids) ){
				foreach ($ids as &$value) {
					$user = user::find($value);
					if( $user->level<10 && $user->verified==0 ){
						$user->delete();
					}
				}
			}else{
				return  response()->json(['message' => 'hacker', 'code' => 'error']);
			}

			return  response()->json(['code' => 'success' , 'task' => 'DeleteUsers']);
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
					$user->active=1;
					$user->save();
				}
			}else{
				return  response()->json(['message' => 'hacker', 'code' => 'error']);
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
	* Change the role of the users
	* @param Stringlist $id user ids
	* @param String $role the role
	* @return Json Response
	*
	*/
	private function changeRole($ids,$role)
	{
		$level = 1;
		if( $role=="User" ){
			$level=1;
		}elseif( $role=="Doctor" ){
			$level=2;
		}elseif( $role=="Admin" ){
			$level=10;
		}elseif( $role=="Moderator" ){
			$level=5;
		}
		if( !is_null($ids) ){
				foreach ($ids as &$value) {
					$user = user::find($value);
					$user->level=$level;
					$user->save();
				}
		}else{
			return  response()->json(['message' => 'hacker', 'code' => 'error']);
		}
		return  response()->json(['code' => 'success' , 'task' => 'changeRole']);
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
		}elseif( Request::get('task')=="loadtablePending" ){
			$x=Request::get('skip');
			return $this->loadTablePending($x);
		}elseif( Request::get('task')=="ConfirmUsers" ){
			$ids=Request::get('users');
			return $this->confirmUsers($ids);
		}elseif( Request::get('task')=="DeleteUsers" ){
			$ids=Request::get('users');
			return $this->deleteUsers($ids);
		}elseif( Request::get('task')=="changeRole" ){
			$ids=Request::get('users');
			$role=Request::get('role');
			return $this->changeRole($ids,$role);
		}else{
			return  response()->json(['message' => 'hacker', 'code' => 'error']);
		}
	}
}
