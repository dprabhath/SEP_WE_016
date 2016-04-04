<?php namespace App\Http\Controllers\users;
use App\user;
use App\Doctor;
use App\Timeslots;
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
use Carbon\Carbon;
class appointmentUser extends Controller {

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
		$this->middleware('loginCheck');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Views
	 */
	public function index()
	{
		
		
	}

	/**
	*
	* show the available slots for spefic doctor
	* @return view
	*/
	public function show($id){
		$doctor=null;
		$userRequested=null;
		$doctor=Doctor::where('id',$id)->first();

		

		if( !is_null($doctor) ){
			$userRequested=user::where('email','=',$doctor->email)->first();
			if( !is_null($userRequested) ){
				$timeslots=Timeslots::where('doctor_id','=',$doctor->id)->first();
				if( !is_null($timeslots) ){


					$periodMinutes=22;
					$periodHours=0;

					$periodMinutes = $periodMinutes + $periodHours*60;

					$tempMonday=$this->stringDateToArray($timeslots->monday);
					$tempCancel=$this->stringDateToArray("9.05-9.10");
					
					$this->timeCal($tempMonday,$tempCancel,$periodMinutes);

					
					

				}else{
					return view('user.appointmetns.place')->with('user',Session::get('user'))->with('userReq',$userRequested)->with('doctor',$doctor);
				}

				return view('user.appointmetns.place')->with('user',Session::get('user'))->with('userReq',$userRequested)->with('doctor',$doctor);

				
			}
		}
		return view('user.appointmetns.place')->with('user',Session::get('user'));
	}


	private function stringDateToArray($str){

		$temp=explode('-', $str);
		$tempTime=array();
		if(count($temp)==2){
			for($x=0; $x<count($temp);$x++){
				$temp1=explode(".", $temp[$x]);
				for($y=0; $y<count($temp1);$y++){
					array_push($tempTime, $temp1[$y]);
				}
				

			}
			
		}
		return $tempTime;


	}

	private function timeCal($day,$Cancel,$periodMinutes){
		$dt = Carbon::now();


					// default start and end
		$startDefault = $dt->copy();
		$endDefault=$dt->copy();

					//canceling start and end
		$startCancel=$dt->copy();
		$endCancel=$dt->copy();

					//Default

		$startDefault->hour=$day[0];
		$startDefault->minute=$day[1];

		$endDefault->hour=$day[2];
		$endDefault->minute=$day[3];

					//canceling

		$startCancel->hour=$Cancel[0];
		$startCancel->minute=$Cancel[1];

		$endCancel->hour=$Cancel[2];
		$endCancel->minute=$Cancel[3];	

		while( floor($startDefault->diffInMinutes($endDefault,false) / $periodMinutes) > 0  ){

			$con1=floor($startDefault->diffInMinutes($startCancel,false) / $periodMinutes);
			$con2=$startDefault->diffInMinutes($endCancel,false);
			//echo "<br>";
			//echo "con1 value : ".$con1;
			//echo "<br>";
			//echo "con2 value : ".$con2;

			if( ($con1 <= 0) && ( $con2 > 0) ){
				//echo '<br>herer';
				$startDefault->hour=$endCancel->hour;
				$startDefault->minute=$endCancel->minute;
			}else{
				//echo "<br>";
				echo $startDefault->toDateTimeString()." to ". $startDefault->copy()->addMinutes($periodMinutes)->toDateTimeString();
				echo "<br>";
				$startDefault->addMinutes($periodMinutes);
			}


		}
	}

}
