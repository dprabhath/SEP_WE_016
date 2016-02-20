<?php namespace App\Http\Controllers\users;
use App\user;
use App\tickets;
use App\tickets_messages;
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
class viewticketController extends Controller {

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
		$this->middleware('loginCheck');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Session::get('user');
		
		return view('user.tickets.view-ticket')->with('user',$user);
		
		//return view('new-ticket');
	}

	
	/**
	*This function will create new tickets
	*
	* Take Post Requsets and save them in the database
	* Task
	*	1. Create new tickets
	*
	* @return View
	**/
	public function inputs(){

		//$user = Session::get('user');
		if(Request::get('task')=="loadtableopendtickets"){
			$tickets = tickets::where('userid',Session::get('userid'))->where('opened',1)->skip(0)->take(20)->get();
			$count = tickets::where('userid',Session::get('userid'))->where('opened',1)->count();
			
			$last_messages = array();

			for($x=0; $x < sizeof($tickets); $x++){
				$tickets_messages = tickets_messages::where('ticket_id',$tickets[$x]->id)->orderBy('id', 'desc')->first();
				$last_messages[] = $tickets_messages;
				//array_push($last_messages,$tickets_messages);

			}

			return  response()->json(['tickets' => $tickets, 'code' => 'success' , 'task' => 'loadtableopendtickets', 'total' =>$count, 'msgs' => $last_messages]);

		}elseif (Request::get('task')=="loadtableclosedtickets") {
			$tickets = tickets::where('userid',Session::get('userid'))->where('opened',0)->skip(0)->take(20)->get();
			$count = tickets::where('userid',Session::get('userid'))->where('opened',0)->count();
			
			$last_messages = array();

			for($x=0; $x < sizeof($tickets); $x++){
				$tickets_messages = tickets_messages::where('ticket_id',$tickets[$x]->id)->orderBy('id', 'desc')->first();
				$last_messages[] = $tickets_messages;
				//array_push($last_messages,$tickets_messages);

			}

			return  response()->json(['tickets' => $tickets, 'code' => 'success' , 'task' => 'loadtableclosedtickets', 'total' =>$count, 'msgs' => $last_messages]);
		}elseif (Request::get('task')=="closeTicket") {

			$ids = Request::get('tickets');
			if(!is_null($ids)){


				foreach ($ids as &$value) {
					$ticket = tickets::find($value);
					if(is_null($ticket)){
						return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
					}

					if($ticket->userid != Session::get('userid')){
						return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
					}


					$ticket->opened = 0;
					$ticket->save();
				}



			}else{
				return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
			}

			return  response()->json(['code' => 'success' , 'task' => 'closeTicket']);
		}elseif (Request::get('task')=="openTicket") {

			$ids = Request::get('tickets');
			if(!is_null($ids)){


				foreach ($ids as &$value) {
					$ticket = tickets::find($value);
					if(is_null($ticket)){
						return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
					}

					if($ticket->userid != Session::get('userid')){
						return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
					}


					$ticket->opened = 1;
					$ticket->save();
				}



			}else{
				return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
			}

			return  response()->json(['code' => 'success' , 'task' => 'openTicket']);
		}



		return  response()->json(['message'=>'Invalid Request','code' => 'error']);
		
		//return 1;
	}
}