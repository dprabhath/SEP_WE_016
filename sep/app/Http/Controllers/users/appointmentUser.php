<?php namespace App\Http\Controllers\users;
use App\user;
use App\Doctor;
use App\doctorSchedule;
use App\Timeslots;
use App\cancelSlots;
use Mail;
use SMS;
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
		
		return view('user.appointmetns.list')->with('user',Session::get('user'));
	}
	/**
	*
	* take the post request and process them
	* @return Json response
	*/
	public function viewInputs()
	{
		if( Request::get('task')=="loadtableconfirmed" ){
			$dt = Carbon::now('Asia/Colombo');
			$schedules=doctorSchedule::where('schedule_end','>',$dt->toDateTimeString())->where('uid','=',Session::get('userid'))->where('confirmed','=',1)->where('cancelUser','=',0)->where('cancelDoctor','=',0)->where('completed','=',0)->skip(0)->take(20)->get();

			$count=doctorSchedule::where('schedule_end','>',$dt->toDateTimeString())->where('uid','=',Session::get('userid'))->where('confirmed','=',1)->where('cancelUser','=',0)->where('cancelDoctor','=',0)->where('completed','=',0)->count();

			$doctorName=array();
			for( $x=0; $x < sizeof($schedules); $x++ ){
				$doctor=Doctor::where('id',$schedules[$x]->did)->select('id','first_name', 'last_name')->first();
				if(is_null($doctor)){
					$doctorName[]="Name Not Available";
				}else{
					$doctorName[]=$doctor;
				}
				
				
			}

			return  response()->json(['schedules' => $schedules, 'code' => 'success' , 'task' => 'loadtableconfirmed', 'total' =>$count,'doctorName' => $doctorName]);

		}elseif( Request::get('task')=="loadtableunconfirmed" ){
			$dt = Carbon::now('Asia/Colombo');
			$schedules=doctorSchedule::where('schedule_end','>',$dt->toDateTimeString())->where('uid','=',Session::get('userid'))->where('confirmed','=',0)->where('cancelUser','=',0)->where('cancelDoctor','=',0)->where('completed','=',0)->skip(0)->take(20)->get();

			$count=doctorSchedule::where('schedule_end','>',$dt->toDateTimeString())->where('uid','=',Session::get('userid'))->where('confirmed','=',0)->where('cancelUser','=',0)->where('cancelDoctor','=',0)->where('completed','=',0)->count();
			$doctorName=array();
			for( $x=0; $x < sizeof($schedules); $x++ ){
				$doctor=Doctor::where('id',$schedules[$x]->did)->select('id','first_name', 'last_name')->first();
				if(is_null($doctor)){
					$doctorName[]="Name Not Available";
				}else{
					$doctorName[]=$doctor;
				}
				
				
			}

			return  response()->json(['schedules' => $schedules, 'code' => 'success' , 'task' => 'loadtableunconfirmed', 'total' =>$count,'doctorName' => $doctorName]);

		}elseif( Request::get('task')=="loadtablecanceled" ){
			$dt = Carbon::now('Asia/Colombo');
			$schedules=doctorSchedule::where('schedule_end','>',$dt->toDateTimeString())->where('uid','=',Session::get('userid'))->where('cancelUser','=',1)->orWhere('cancelDoctor','=',1)->skip(0)->take(20)->get();

			$count=doctorSchedule::where('schedule_end','>',$dt->toDateTimeString())->where('uid','=',Session::get('userid'))->where('cancelUser','=',1)->orWhere('cancelDoctor','=',1)->count();
			$doctorName=array();
			for( $x=0; $x < sizeof($schedules); $x++ ){
				$doctor=Doctor::where('id',$schedules[$x]->did)->select('id','first_name', 'last_name')->first();
				if(is_null($doctor)){
					$doctorName[]="Name Not Available";
				}else{
					$doctorName[]=$doctor;
				}
				
				
			}

			return  response()->json(['schedules' => $schedules, 'code' => 'success' , 'task' => 'loadtablecanceled', 'total' =>$count,'doctorName' => $doctorName]);

		}elseif( Request::get('task')=="loadtablecompleted" ){
			$dt = Carbon::now('Asia/Colombo');
			$schedules=doctorSchedule::where('uid','=',Session::get('userid'))->where('cancelUser','=',0)->where('cancelDoctor','=',0)->where('completed','=',1)->skip(0)->take(20)->get();

			$count=doctorSchedule::where('uid','=',Session::get('userid'))->where('cancelUser','=',0)->where('cancelDoctor','=',0)->where('completed','=',1)->count();
			$doctorName=array();
			for( $x=0; $x < sizeof($schedules); $x++ ){
				$doctor=Doctor::where('id',$schedules[$x]->did)->select('id','first_name', 'last_name')->first();
				if(is_null($doctor)){
					$doctorName[]="Name Not Available";
				}else{
					$doctorName[]=$doctor;
				}
				
				
			}

			return  response()->json(['schedules' => $schedules, 'code' => 'success' , 'task' => 'loadtablecompleted', 'total' =>$count,'doctorName' => $doctorName]);

		}elseif( Request::get('task')=="loadtableall" ){
			$dt=Carbon::now('Asia/Colombo');
			$schedules=doctorSchedule::where('uid','=',Session::get('userid'))->skip(0)->take(20)->get();

			$count=doctorSchedule::where('uid','=',Session::get('userid'))->count();
			$doctorName=array();
			for( $x=0; $x < sizeof($schedules); $x++ ){
				$doctor=Doctor::where('id',$schedules[$x]->did)->select('id','first_name', 'last_name')->first();
				if(is_null($doctor)){
					$doctorName[]="Name Not Available";
				}else{
					$doctorName[]=$doctor;
				}
			}

			return  response()->json(['schedules' => $schedules, 'code' => 'success' , 'task' => 'loadtableall', 'total' =>$count,'doctorName' => $doctorName]);
		}elseif( Request::get('task')=="viewDetails" ){
			$appointment=Request::get('appointment');
			if( is_null($appointment) ){
				return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
			}
			$schedule=doctorSchedule::where('uid','=',Session::get('userid'))->where('id','=',$appointment[0])->first();
			if( is_null($schedule) ){
				return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
			}
			$doctor=Doctor::where('id',$schedule->did)->select('id','first_name', 'last_name','address','phone','specialization')->first();
			return  response()->json(['schedules' => $schedule, 'code' => 'success' , 'task' => 'viewDetails','doctor' => $doctor]);

		}elseif ( Request::get('task')=="cancelAppointment" ) {
			$appointments=Request::get('appointments');
			if( is_null($appointments) ){
				return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
			}
			foreach ($appointments as &$value) {
				$schedule=doctorSchedule::where('uid','=',Session::get('userid'))->where('id','=',$value)->first();
				if( is_null($schedule) ){
					continue;
				}
				$schedule->cancelUser=1;
				$schedule->save();
			}
			return  response()->json(['code' => 'success' , 'task' => 'cancelAppointment']);
		}

		return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
	}
	/**
	*
	* take the post request and process them
	* @return Json response
	*/
	public function inputs()
	{
		if( Request::get('task')=="makeAppointment" ){
			$doctor_id=Session::get('requestedDoctor');
			$timeVal=Session::get('timeval');
			$start=Request::get('start');
			$end=Request::get('end');
			$check=false;
			if( is_null($timeVal) ){
				return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
			}
			foreach ($timeVal as $key => $values) {

				foreach ($values as $value) {
    				if( $value->start==trim($start) && $value->end==trim($end) ){
    				$check=true;
    				break;
    				}
    				//return  response()->json(['message' => count($values), 'code' => 'error']);
				}
    			
			}

			if( !is_null($doctor_id) && !is_null($start) && !is_null($end) && !is_null($timeVal) && $check==true ){
				$doctor=Doctor::where('id',$doctor_id)->first();
				$timeSlot=Timeslots::where('doctor_id','=',$doctor->id)->first();
				if( !is_null($doctor) || !is_null($timeSlot) ){
					$period=explode(".", $timeSlot->period);
					if( count($period)!=2 ){
						return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
					}
					$periodMinutes=$period[1];
					$periodHours=$period[0];
					$periodMinutes = $periodMinutes + $periodHours*60;
					//verify slot is free
					$startDate=Carbon::createFromFormat('Y-m-d H:i:s',$start);
					$endDate=Carbon::createFromFormat('Y-m-d H:i:s',$end);
					$scheduleFree=doctorSchedule::where('did','=',$doctor_id)->where('schedule_start','=',$startDate->toDateTimeString())->where('schedule_end','=',$endDate->toDateTimeString())->where('cancelUser','=',0)->where('cancelDoctor','=',0)->first();
					if( !is_null($scheduleFree) ){
						return  response()->json(['message' => 'Slot is Already reserved please select another or refresh', 'code' => 'error']);
					}
					//if( $startDate->diffInMinutes($endDate,false)!=$periodMinutes ){
					//	return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
					//}
					//verify start is above 1 day
					$dt = Carbon::now('Asia/Colombo');
					$dt->hour = 0;
					$dt->minute = 0;
					$dt->second = 0;
					$daysLeft=$dt->diffInDays($startDate);
					if( $daysLeft<2 || $daysLeft>8 ){
						return  response()->json(['message' => 'Refresh the page', 'code' => 'error']);
					}
					//verify user dont have any schdules with the same doctor within a week
					// dont check for the cancel ones
					$dt->addDays(2);
					$dtEnd=$dt->copy()->addDays(7);
					$schedules=doctorSchedule::where('did','=',$doctor_id)->where('uid','=',Session::get('userid'))->where('schedule_start','>',$dt->toDateTimeString())->where('schedule_end','<',$dtEnd->toDateTimeString())->where('cancelUser','=',0)->where('cancelDoctor','=',0)->first();
					if( !is_null($schedules) ){
						return  response()->json(['message' => 'You already have a appointment in this week', 'code' => 'error']);
					}
					//save the new schedule and send a email to the user
					$newSchedule= new doctorSchedule;
					$newSchedule->did=$doctor_id;
					$newSchedule->uid=Session::get('userid');
					$newSchedule->schedule_start=$startDate->toDateTimeString();
					$newSchedule->schedule_end=$endDate->toDateTimeString();
					$newSchedule->code=rand(10000, 99999);
					$newSchedule->trys=0;
					if($newSchedule->save()){
						$dName=$doctor->first_name." ".$doctor->last_name;
						$user=Session::get('user');
						Mail::send('mailtemplate/appointmentPlaced', ['name'=> $user->name,'dName'=>$dName,'Date'=>$startDate->toDateString(),'Time'=>$startDate->format('h:i A'),'code'=>$newSchedule->code], function ($m) use ($user) {
							$m->from('daemon@mail.altairsl.us', 'Native Physician');

							$m->to($user->email, $user->name)->subject('Appointment Details');
						});

						return  response()->json(['message' => 'Your appointment placed successfully', 'code' => 'success','task'=>'makeAppointment']);
					}else{
						return  response()->json(['message' => 'Selected slot is already reserved', 'code' => 'error']);
					}
					

				}else{
					return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
				}
			}else{
				return  response()->json(['message' => 'Data missmatched', 'code' => 'error']);
			}
		}else{
			return  response()->json(['message' => 'Invalid Option', 'code' => 'error']);
		}

	}

	/**
	*
	* show the available slots for spefic doctor
	* @return view
	*/
	public function show($id)
	{
		$doctor=null;
		$userRequested=null;
		$doctor=Doctor::where('id',$id)->first();
		if( !is_null($doctor) ){
			$userRequested=user::where('email','=',$doctor->email)->first();
			if( !is_null($userRequested) ){
				$timeSlots=Timeslots::where('doctor_id','=',$doctor->id)->first();
				if( !is_null($timeSlots) ){
					//getting the time period
					$period=explode(".", $timeSlots->period);
					if(count($period)!=2){
						return view('user.appointmetns.place')->with('user',Session::get('user'))->with('userReq',$userRequested)->with('doctor',$doctor);
					}
					$periodMinutes=$period[1];
					$periodHours=$period[0];
					$periodMinutes = $periodMinutes + $periodHours*60;
					// end of the processing the time format initialiation
					$dt = Carbon::now('Asia/Colombo');
					$dt->second=0;
					//$dt = Carbon::parse('2012-9-6 23:26:11.123789');
					$dayCount=0;
					$dt->addDays(2);
					$timetable=array();
					$timevals=array();
					while($dayCount<7){
						$day=array();
						if($dt->dayOfWeek==1){
							//echo "monday<br>";
							$day=$this->stringDateToArray($timeSlots->monday);
						}elseif($dt->dayOfWeek==2){
							$day=$this->stringDateToArray($timeSlots->tuesday);
							//echo "tuesday<br>";
						}elseif($dt->dayOfWeek==3){
							$day=$this->stringDateToArray($timeSlots->wednesday);
							//echo "wedensday<br>";
						}elseif($dt->dayOfWeek==4){
							$day=$this->stringDateToArray($timeSlots->thursday);
							//echo "Thursday<br>";
						}elseif($dt->dayOfWeek==5){
							$day=$this->stringDateToArray($timeSlots->friday);
							//echo "Friday<br>";
						}elseif($dt->dayOfWeek==6){
							$day=$this->stringDateToArray($timeSlots->saturday);
							//echo "Saturday<br>";
						}elseif($dt->dayOfWeek==0){
							$day=$this->stringDateToArray($timeSlots->sunday);
							//echo "Sunday<br>";
						}
						if(count($day)!=4){
							$dt->addDay();
							$dayCount++;
							continue;
						}
						$cancelTimeDb=cancelSlots::where('did','=',$doctor->id)->where('slotdate','=',$dt->toDateString())->first();
						$tempCancel=$this->stringDateToArray("0.00-0.00");
						if( !is_null($cancelTimeDb) ){
							$tempCancel=$this->stringDateToArray($cancelTimeDb->time);
							if(count($tempCancel)!=4){
								$tempCancel=$this->stringDateToArray("0.00-0.00");
							}
						}
						$key=$dt->toDateString();
						$returnArray=array();
						$returnArray=$this->timeCal($day,$tempCancel,$periodMinutes,$dt,$doctor->id);
						//$timetable[$key]=$this->timeCal($day,$tempCancel,$periodMinutes,$dt,$doctor->id);
						$timetable[$key]=$returnArray['times'];
						$timevals[$key]=$returnArray['vals'];
						$dt->addDay();
						$dayCount++;
					}
					Session::put('requestedDoctor',$doctor->id);
					Session::put('timeval',$timevals);
					return view('user.appointmetns.place')->with('user',Session::get('user'))->with('userReq',$userRequested)->with('doctor',$doctor)->with('timetable',$timetable)->with('timevals',$timevals);
				}else{
					return view('user.appointmetns.place')->with('user',Session::get('user'))->with('userReq',$userRequested)->with('doctor',$doctor);
				}
				return view('user.appointmetns.place')->with('user',Session::get('user'))->with('userReq',$userRequested)->with('doctor',$doctor);
			}
		}
		return view('user.appointmetns.place')->with('user',Session::get('user'));
	}

	/**
	*
	*	split the row string to hours and minutes
	*	@return String array
	*/
	private function stringDateToArray($str)
	{
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
	/**
	* @param $day information regarding the schedule start/end time
	* @param $Cancel information regarding the canceled schedule start/end time
	* @param $periodMinutes Period of a schedule
	* @param $dt Datetime Object which contains the date of schedule
	* @param $doctor_id Id of the Doctor
	*
	* put time scedules into an array, filter Cancled timeslots and already reserved ones
	* @return array of schedules
	*/
	private function timeCal($day,$Cancel,$periodMinutes,$dt,$doctor_id)
	{
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
		$times=array();
		$timeval=array(); // returning array of the available time slots
		$twodArray=array();
		// process default time
		while( floor($startDefault->diffInMinutes($endDefault,false) / $periodMinutes) > 0  ){
			$con1=floor($startDefault->diffInMinutes($startCancel,false) / $periodMinutes);
			$con2=$startDefault->diffInMinutes($endCancel,false);
			// process cancel time
			if( ($con1 <= 0) && ( $con2 > 0) ){
				//echo '<br>herer';
				$startDefault->hour=$endCancel->hour;
				$startDefault->minute=$endCancel->minute;
			}else{
				$schedules=doctorSchedule::where('did','=',$doctor_id)->where('schedule_start','=',$startDefault->toDateTimeString())->where('cancelUser','=',0)->where('cancelDoctor','=',0)->first();
				if( is_null($schedules) ){
					$msg=$startDefault->format('h:i A')."-". $startDefault->copy()->addMinutes($periodMinutes)->format('h:i A');
					array_push($times, $msg);
					$obj = (object) array('start' => $startDefault->toDateTimeString() , 'end' => $startDefault->copy()->addMinutes($periodMinutes)->toDateTimeString());
					array_push($timeval,$obj);
				}
				$startDefault->addMinutes($periodMinutes);
			}
		}
		$twodArray['times']=$times;
		$twodArray['vals']=$timeval;
		
		return $twodArray;
	}

}
