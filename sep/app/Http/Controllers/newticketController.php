<?php namespace App\Http\Controllers;
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
				return view('new-ticket')->with('user',$user);
			}
		//return view('new-ticket');
	}

	

	
	public function inputs(){

		$user = user::where('id',Session::get('userid'))->first();
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
		return view('new-ticket')->with('user',$user)->with('created',1);
		//return 1;
	}
}