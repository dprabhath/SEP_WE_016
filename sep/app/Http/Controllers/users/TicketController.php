<?php namespace App\Http\Controllers\users;
use App\User;
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
class TicketController extends Controller 
{

	/*
	|--------------------------------------------------------------------------
	| Ticket Controller - User
	|--------------------------------------------------------------------------
	|
	| @author Michika Iranga Perera
	|
	| This is the users tickets handling controller
	|
	*/
	private $resultCount=10;
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
		$user=Session::get('user');
		return view('user.tickets.viewTicket')->with('user',$user);
	}
	/**
	*
	* Return the Opened tickets as Json Response
	* 
	* @param get the pagination number
	* @return Json Response
	*
	*/
	private function loadTableOpendTickets($skiper)
	{
		$tickets=tickets::where('userid',Session::get('userid'))->where('opened',1)->skip($this->resultCount*$skiper)->take($this->resultCount)->get();
		$count=tickets::where('userid',Session::get('userid'))->where('opened',1)->count();
		$lastMessages=array();
		for( $x=0; $x < sizeof($tickets); $x++ ){
			$ticketsMessages=tickets_messages::where('ticket_id',$tickets[$x]->id)->orderBy('id', 'desc')->first();
			$lastMessages[]=$ticketsMessages;
		}
		return  response()->json(['tickets' => $tickets, 'code' => 'success' , 'task' => 'loadtableopendtickets', 'total' =>$count, 'msgs' => $lastMessages,'skips' =>$this->resultCount]);
	}
	/**
	*
	* Return the Closed tickets as Json Response
	* 
	* @param get the pagination number
	* @return Json Response
	*
	*/
	private function loadTableClosedTickets($skiper)
	{
		$tickets=tickets::where('userid',Session::get('userid'))->where('opened',0)->skip($this->resultCount*$skiper)->take($this->resultCount)->get();
		$count=tickets::where('userid',Session::get('userid'))->where('opened',0)->count();
		$lastMessages=array();
		for( $x=0; $x < sizeof($tickets); $x++ ){
			$ticketsMessages=tickets_messages::where('ticket_id',$tickets[$x]->id)->orderBy('id', 'desc')->first();
			$lastMessages[]=$ticketsMessages;
		}
		return  response()->json(['tickets' => $tickets, 'code' => 'success' , 'task' => 'loadtableclosedtickets', 'total' =>$count, 'msgs' => $lastMessages,'skips' =>$this->resultCount]);
	}
	/**
	*
	* Change the state of the ticket to close
	* 
	* @param Integer $ids Ticket ID
	* @return Json Response
	*
	*/
	private function closeTickets($ids)
	{
		if( !is_null($ids) ){
			foreach ( $ids as &$value ) {
				$ticket=tickets::find($value);
				if( is_null($ticket) ){
					return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
				}
				if( $ticket->userid != Session::get('userid') ){
					return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
				}
				$ticket->opened=0;
				$ticket->save();
			}
		}else{
			return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
		}
		return  response()->json(['code' => 'success' , 'task' => 'closeTicket']);
	}
	/**
	*
	* Change the state of the ticket to open
	* 
	* @param Integer $ids Ticket ID
	* @return Json Response
	*
	*/
	private function openTickets($ids)
	{
		if( !is_null($ids) ){
			foreach ( $ids as &$value ) {
				$ticket=tickets::find($value);
				if( is_null($ticket) ){
					return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
				}
				if( $ticket->userid!=Session::get('userid') ){
					return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
				}
				$ticket->opened=1;
				$ticket->save();
			}
		}else{
			return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
		}
		return  response()->json(['code' => 'success' , 'task' => 'openTicket']);
	}
	/**
	*
	* Get the Tickets Reply
	* @param String $message Ticket body
	* @param Integer $ticketId Ticket ID
	* @return Json Response
	*
	*/
	private function replyTickets($message,$ticket_id)
	{
		$user=Session::get('user');
		if( !is_null(trim($message)) && !is_null($ticket_id) ){
			$ticket=tickets::find($ticket_id);
			if( is_null($ticket) ){
				return  response()->json(['message'=>'Invalid Request','code' => 'error']);
			}
			if( ($ticket->userid != Session::get('userid') && $user->level < 10) || $ticket->opened == 0 ){
				return  response()->json(['message'=>'Invalid Request','code' => 'error']);
			}
			$ticketMsg=new tickets_messages;
			$ticketMsg->user_id=Session::get('userid');
			$ticketMsg->message=$message;
			$ticketMsg->ticket_id=$ticket->id;
			$ticketMsg->save();
			return  response()->json(['code' => 'success' , 'task' => 'replyTickets','msg' => $ticketMsg]);
		}else{
			return  response()->json(['message'=>'Invalid Request','code' => 'error']);
		}
		return  response()->json(['message'=>'Invalid Request','code' => 'error']);
	}
/**
	*This function will handle the post requests
	*
	* 
	* Tasks
	*	1. Load Opend Tickets
	*	2. Load Closed Tickets 
	*	3. Close the tickets
	*	4. Open the tickets
	* 
	**/
	public function inputs()
	{
		if( Request::get('task')=="loadtableopendtickets" ){
			$x=Request::get('skip');
			return $this->loadTableOpendTickets($x);
		}elseif( Request::get('task')=="loadtableclosedtickets" ){
			$x=Request::get('skip');
			return $this->loadTableClosedTickets($x);
		}elseif( Request::get('task')=="closeTicket" ){
			$ids=Request::get('tickets');
			return $this->closeTickets($ids);
		}elseif( Request::get('task')=="openTicket" ){
			$ids=Request::get('tickets');
			return $this->openTickets($ids);
		}elseif( Request::get('task')=="viewTicket" ){
			$user=Session::get('user');
			$ids=Request::get('ticket');
			if( !is_null($ids) ){
				$ticket=tickets::find($ids);
				if(is_null($ticket)){
					abort(404);
				}
				if( $ticket->userid != Session::get('userid')  && $user->level < 10 ){
					abort(404);
				}
				$admin=adminUserTickets::where('ticketid',$ticket->id)->first();
				$staff=null;
				if( !is_null($admin) ){
					$staff=user::find($admin->adminid);
				}
				$ticketsMessages=tickets_messages::where('ticket_id',$ticket->id)->orderBy('id', 'asc')->get();
				return view('user.tickets.reply')->with('user',$user)->with('messages', $ticketsMessages)->with('ticket',$ticket)->with('staff',$staff);
			}else{
				abort(404);
			}
		}elseif( Request::get('task')=="replyTickets" ){
			$message=Request::get('text');
			$ticket_id=Request::get('ticket_id');
			return $this->replyTickets($message,$ticket_id);
		}
	}
}
