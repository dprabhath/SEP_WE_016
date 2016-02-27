<?php namespace App\Http\Controllers\admin;
use App\user;
use App\tickets;
use App\tickets_messages;
use App\adminUserTickets;
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
		
		return view('admin/viewTicket')->with('user',$user);
		
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

		$user = Session::get('user');
		if(Request::get('task')=="loadtableopendtickets"){

			$lists = adminUserTickets::where('adminid',$user->id)->lists('ticketid');
			$tickets = tickets::whereIn('id', $lists)->where('opened',1)->skip(0)->take(20)->get();


			$count = tickets::whereIn('id', $lists)->where('opened',1)->count();


			//$tickets = tickets::where('opened',1)->skip(0)->take(20)->get();
			//$count = tickets::where('opened',1)->count();
			
			$lastMessages = array();

			for($x=0; $x < sizeof($tickets); $x++){
				$ticketsMessages = tickets_messages::where('ticket_id',$tickets[$x]->id)->orderBy('id', 'desc')->first();
				$lastMessages[] = $ticketsMessages;
				//array_push($lastMessages,$ticketsMessages);

			}

			return  response()->json(['tickets' => $tickets, 'code' => 'success' , 'task' => 'loadtableopendtickets', 'total' =>$count, 'msgs' => $lastMessages]);

		}elseif (Request::get('task')=="loadtableAvailabletickets") {

			$lists = adminUserTickets::lists('ticketid');
			$tickets = tickets::whereNotIn('id', $lists)->where('opened',1)->skip(0)->take(20)->get();


			$count = tickets::whereNotIn('id', $lists)->where('opened',1)->count();
			
			$lastMessages = array();

			for($x=0; $x < sizeof($tickets); $x++){
				$ticketsMessages = tickets_messages::where('ticket_id',$tickets[$x]->id)->orderBy('id', 'desc')->first();
				$lastMessages[] = $ticketsMessages;
				//array_push($lastMessages,$ticketsMessages);

			}

			return  response()->json(['tickets' => $tickets, 'code' => 'success' , 'task' => 'loadtableAvailabletickets', 'total' =>$count, 'msgs' => $lastMessages]);
		}elseif (Request::get('task')=="loadtableclosedtickets") {

			$lists = adminUserTickets::where('adminid',$user->id)->lists('ticketid');
			$tickets = tickets::whereIn('id', $lists)->where('opened',0)->skip(0)->take(20)->get();


			$count = tickets::whereIn('id', $lists)->where('opened',0)->count();
			
			$lastMessages = array();

			for($x=0; $x < sizeof($tickets); $x++){
				$ticketsMessages = tickets_messages::where('ticket_id',$tickets[$x]->id)->orderBy('id', 'desc')->first();
				$lastMessages[] = $ticketsMessages;
				//array_push($lastMessages,$ticketsMessages);

			}

			return  response()->json(['tickets' => $tickets, 'code' => 'success' , 'task' => 'loadtableclosedtickets', 'total' =>$count, 'msgs' => $lastMessages]);
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
			//$user = Session::get('user');
			$ids = Request::get('ticket');
			
			
			if(!is_null($ids)){
				$ticketOwner;
				$ticket = tickets::find($ids);
				if(is_null($ticket)){
					abort(404);
				}else{
					$ticketOwner = user::find($ticket->userid);
				}
				
				$ticketsMessages = tickets_messages::where('ticket_id',$ticket->id)->orderBy('id', 'asc')->get();
				return view('admin.reply')->with('user',$user)->with('messages', $ticketsMessages)->with('ticket',$ticket)->with('ticket_owner',$ticketOwner);



			}else{
				abort(404);
			}

			//return  response()->json(['code' => 'success' , 'task' => 'openTicket']);
		}elseif (Request::get('task')=="replyTickets") {
			//$user = Session::get('user');

			$message = Request::get('text');
			$ticketId = Request::get('ticket_id');
			$count = adminUserTickets::where('ticketid',$ticketId)->count();

			if($count==0){
				$adminUt = new adminUserTickets;
				$adminUt->ticketid = $ticketId;
				$adminUt->adminid = $user->id;
				$adminUt->save();
			}else{
				$count = adminUserTickets::where('adminid',$user->id)->where('ticketid',$ticketId)->count();
				if($count==0){
					return response()->json(['message'=>'Invalid Request','code' => 'error']);
				}
			}

			
			if(!is_null(trim($message)) && !is_null($ticketId)){
				$ticket = tickets::find($ticketId);

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