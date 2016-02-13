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
class newticketController extends Controller {

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
		
		return view('user.tickets.new-ticket')->with('user',$user);
		
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

		$user =Session::get('user');
		if(is_null($user)){
			return Redirect::to('login');
		}

		if(Request::get('options')=="custom"){
			$heading = Request::get('heading');
		}else{
			$heading = Request::get('options');
		}

		


		$ticket = new tickets;
		$ticket->userid = Session::get('userid');
		$ticket->subject = $heading;
		$ticket->opened=1;
		$ticket->save();


		$ticketMsg = new tickets_messages;
		$ticketMsg->user_id = Session::get('userid');
		$ticketMsg->message = Request::get('txtarea');
		$ticketMsg->ticket_id = $ticket->id;
		$ticketMsg->save();
		//return view('user.tickets.new-ticket')->with('user',$user)->with('created',1);
		 return redirect('view-ticket');
		//return 1;
	}
}