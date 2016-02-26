<?php namespace App\Http\Controllers\admin;
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
class ticketControllerAdmin extends Controller {

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
		$user = Session::get('user');
		
		return view('admin/view-ticket')->with('user',$user);
		
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
			$tickets = tickets::where('opened',1)->skip(0)->take(20)->get();
			$count = tickets::where('opened',1)->count();
			
			$last_messages = array();

			for($x=0; $x < sizeof($tickets); $x++){
				$tickets_messages = tickets_messages::where('ticket_id',$tickets[$x]->id)->orderBy('id', 'desc')->first();
				$last_messages[] = $tickets_messages;
				//array_push($last_messages,$tickets_messages);

			}

			return  response()->json(['tickets' => $tickets, 'code' => 'success' , 'task' => 'loadtableopendtickets', 'total' =>$count, 'msgs' => $last_messages]);

		}elseif (Request::get('task')=="loadtableclosedtickets") {
			$tickets = tickets::where('opened',0)->skip(0)->take(20)->get();
			$count = tickets::where('opened',0)->count();
			
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

					


					$ticket->opened = 1;
					$ticket->save();
				}



			}else{
				return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
			}

			return  response()->json(['code' => 'success' , 'task' => 'openTicket']);
		}elseif (Request::get('task')=="viewTicket") {
			$user = Session::get('user');
			$ids = Request::get('ticket');
			
			if(!is_null($ids)){
				$ticket_owner;
				$ticket = tickets::find($ids);
				if(is_null($ticket)){
					abort(404);
				}else{
					$ticket_owner = user::find($ticket->userid);
				}
				
				$tickets_messages = tickets_messages::where('ticket_id',$ticket->id)->orderBy('id', 'asc')->get();
				return view('admin.reply')->with('user',$user)->with('messages', $tickets_messages)->with('ticket',$ticket)->with('ticket_owner',$ticket_owner);



			}else{
				abort(404);
			}

			//return  response()->json(['code' => 'success' , 'task' => 'openTicket']);
		}elseif (Request::get('task')=="replyTickets") {
			$user = Session::get('user');
			$message = Request::get('text');
			$ticket_id = Request::get('ticket_id');

			if(!is_null(trim($message)) && !is_null($ticket_id)){
				$ticket = tickets::find($ticket_id);

				if(is_null($ticket)){
					return  response()->json(['message'=>'Invalid Request','code' => 'error']);
				}
				if($ticket->opened == 0){
					return  response()->json(['message'=>'Ticket Should be opened','code' => 'error']);
				}

				$ticketMsg = new tickets_messages;
				$ticketMsg->user_id = Session::get('userid');
				$ticketMsg->message = $message;
				$ticketMsg->ticket_id = $ticket->id;
				$ticketMsg->save();
				return  response()->json(['code' => 'success' , 'task' => 'replyTickets','msg' => $ticketMsg]);
			}else{
				return  response()->json(['message'=>'Invalid Request','code' => 'error']);
			}
		}



		return  response()->json(['message'=>'Invalid Request','code' => 'error']);
		
		//return 1;
	}
}