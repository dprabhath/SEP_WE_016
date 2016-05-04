<?php namespace App\Http\Controllers;

use App\Doctor;
use App\user;
use App\pendingDoctor;
use App\doctorSchedule;
use App\cancelSlots;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Request;
use Session;
use Mail;
use DB;
use App\reviews;
use App\Timeslots;
use App\PendingEdit;
use Carbon\Carbon;

class DoctorController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('AdminloginCheck');
	}

	/**
	 * Shows the Doctor List to the user.
	 *
	 * @return index view
	 */
	public function index()
	{
		$doctors = Doctor::all();
		$user = Session::get('user');

		return view('doctor.index')->with('doctors', $doctors)->with('user',$user);
		//return $doctors;
	}

	/**
	 * Shows the profile of a specific Doctor to the user.
	 *
	 * @return show view
	 */
	public function show($id)
	{
		$doctor = Doctor::findOrFail($id);
		$user = Session::get('user');
		$reviews = reviews::all()->where('doctor_id', $doctor->id);

		return View::make('doctor.show')->with('doctor', $doctor)->with('user',$user)->with('reviews',$reviews);
	}

	/**
	 * Shows the page for adding a new Doctor to the user.
	 *
	 * @return newdoctor view
	 */
	public function newdoctor()
	{
		$user = Session::get('user');

		return View::make('doctor.newdoctor')->with('user',$user);
	}

	/**
	 * Shows the page for creating a new Cancel Slot.
	 *
	 * @return createcancelslot view
	 */
	public function setCancelSlot()
	{
		$user = Session::get('user');

		return View::make('doctor.createcancelslot')->with('user',$user);
	}

	/**
	 * Inserts a new Cancel Slot.
	 *
	 * @return createcancelslot view
	 */
	public function insertCancelSlot()
	{
		$user = Session::get('user');

		$from = Request::get('from');
		$till = Request::get('till');
		$date = Request::get('date');

		$newCancelSlot = new cancelSlots();

		$startDateTime = Carbon::createFromFormat('Y/m/d-H.i', $date .'-'. $from);
		$endDateTime = Carbon::createFromFormat('Y/m/d-H.i', $date .'-'. $till);

		$newCancelSlot->did = $user->id;
		$newCancelSlot->time = $from .'-'. $till;
		$newCancelSlot->slotdate = $startDateTime->toDateString();

		$newCancelSlot->save();

		$appointments = doctorSchedule::where(function ($query) use ($startDateTime, $endDateTime) { $query->where('schedule_start', '>', $startDateTime->toDateTimeString())->where('schedule_start', '<', $endDateTime->toDateTimeString());})->orWhere(function ($query) use ($startDateTime, $endDateTime) { $query->where('schedule_end', '>', $startDateTime->toDateTimeString())->where('schedule_end', '<', $endDateTime->toDateTimeString());})->get();

		$currentDoctor = Doctor::find($user->id);
		$doctorName = $currentDoctor->first_name .' '. $currentDoctor->last_name;

		foreach ($appointments as $value) {
    		$currentUser = User::find($value->uid);

    		Mail::send('mailtemplate/appointmentCancelled', ['name'=> $currentUser->name,'doctor'=> $doctorName], function ($m) use ($currentUser) 
					{
						$m->from('daemon@mail.altairsl.us', 'Daemon');
						$m->to($currentUser->email, $currentUser->name)->subject('Wedaduru Appointment Notice');
					});
    		doctorSchedule::where('id', $value->id)->update(['cancelDoctor' => '1']);
		}

		return View::make('doctor.createcancelslot')->with('user',$user);
	}


	/**
	 * Shows the Doctor List to the user.
	 *
	 * @return index view
	 */
	public function createSchedule()
	{
		$user = Session::get('user');
		$ifExists = Timeslots::where('doctor_id', $user->id)->get();
		$created = 0;

		if(count($ifExists) > 0) {
			$created = 1;
		}

		return view('doctor.createschedule')->with('user',$user)->with('created',$created);
	}

	/**
	 * Shows the Doctor List to the user.
	 *
	 * @return index view
	 */
	public function updateSchedule()
	{
		$user = Session::get('user');

		$ifExists = Timeslots::where('doctor_id', $user->id)->get();
		$created = 0;

		if(count($ifExists) > 0) {
			Timeslots::where('doctor_id', $user->id)->update(['monday' => Request::get('monday_from') .'-'. Request::get('monday_till')]);
			Timeslots::where('doctor_id', $user->id)->update(['tuesday' => Request::get('tuesday_from') .'-'. Request::get('tuesday_till')]);
			Timeslots::where('doctor_id', $user->id)->update(['wednesday' => Request::get('wednesday_from') .'-'. Request::get('wednesday_till')]);
			Timeslots::where('doctor_id', $user->id)->update(['thursday' => Request::get('thursday_from') .'-'. Request::get('thursday_till')]);
			Timeslots::where('doctor_id', $user->id)->update(['friday' => Request::get('friday_from') .'-'. Request::get('friday_till')]);
			Timeslots::where('doctor_id', $user->id)->update(['saturday' => Request::get('saturday_from') .'-'. Request::get('saturday_till')]);
			Timeslots::where('doctor_id', $user->id)->update(['sunday' => Request::get('sunday_from') .'-'. Request::get('sunday_till')]);
			Timeslots::where('doctor_id', $user->id)->update(['notes' => 'None']);
			$created = 1;
		}
		else {
			$newTimeslot = new Timeslots();

			$newTimeslot->doctor_id = $user->id;
			$newTimeslot->monday = Request::get('monday_from') .'-'. Request::get('monday_till');
			$newTimeslot->tuesday = Request::get('tuesday_from') .'-'. Request::get('tuesday_till');
			$newTimeslot->wednesday = Request::get('wednesday_from') .'-'. Request::get('wednesday_till');
			$newTimeslot->thursday = Request::get('thursday_from') .'-'. Request::get('thursday_till');
			$newTimeslot->friday = Request::get('friday_from') .'-'. Request::get('friday_till');
			$newTimeslot->saturday = Request::get('saturday_from') .'-'. Request::get('saturday_till');
			$newTimeslot->sunday = Request::get('sunday_from') .'-'. Request::get('sunday_till');
			$newTimeslot->created = 1;
			$newTimeslot->notes = 'None';

			$newTimeslot->save();
		}

		return view('doctor.createschedule')->with('user',$user)->with('created',$created);
		//return $doctors;
	}


	/**
	 * Returns view consisting of the list of approved Informal Physicians
	 *
	 * @return newdoctor view
	 */
	public function approvedList()
	{
		$user = Session::get('user');
		$doctors = Doctor::where('formal', 0)->get();

		return View::make('doctor.approvedlist')->with('user',$user)->with('doctors',$doctors);
	}

	/**
	 * Returns view consisting of the list of Physicians Reviews
	 *
	 * @return newdoctor view
	 */
	public function doctorReview($id)
	{
		$user = Session::get('user');
		$doctor = Doctor::findOrFail($id);
		$reviews = reviews::all()->where('doctor_id', $doctor->id);

		return View::make('doctor.review')->with('user',$user)->with('doctor',$doctor)->with('reviews',$reviews);
	}

	/**
	 * Shows the page for approving and deleting new Doctor Requests to the admin.
	 *
	 * @return pendingdoctor view
	 */
	public function pendingdoctor()
	{
		$doctors = pendingDoctor::all();
		$user = Session::get('user');

		return View::make('doctor.pendingdoctor')->with('doctors', $doctors)->with('user',$user);
	}

	/**
	 * Shows the page for editing a Doctor's page to the admin.
	 *
	 * @return edit view
	 */
	public function edit($id)
	{
		$doctor = Doctor::find($id);
		$user = Session::get('user');

		return view('doctor.edit')->with('doctor', $doctor)->with('user',$user);
	}

	/**
	 * Shows the page of a pending Doctor to the admin.
	 *
	 * @return showpending view
	 */
	public function showPending($id)
	{
		$doctor = pendingDoctor::findOrFail($id);
		$user = Session::get('user');

		return view('doctor.showpending')->with('doctor', $doctor)->with('user',$user);
	}

	/**
	 * Shows the page of a pending Doctor to the admin.
	 *
	 * @return showpending view
	 */
	public function suggestEdit($id)
	{
		$user = Session::get('user');
		$doctor = Doctor::findOrFail($id);
		
		return view('doctor.suggestEdit')->with('user',$user)->with('doctor',$doctor);
	}

	/**
	 * Shows the page of a pending Doctor to the admin.
	 *
	 * @return showpending view
	 */
	public function insertSuggestEdit($id)
	{
		$user = Session::get('user');
		$doctor = Doctor::find($id);

		$newEdit = new PendingEdit();

		$newEdit->doctor_id = $id;
		$newEdit->doctorname = $doctor->first_name .' '. $doctor->last_name;
		$newEdit->user_id = $user->id;
		$newEdit->username = $user->name;
		$newEdit->field = Request::get('field');
		$newEdit->value = Request::get('fieldValue');

		$newEdit->save();
		
		return view('doctor.suggestEdit')->with('user',$user)->with('doctor',$doctor);
	}

	/**
	 * Shows the page of a pending Doctor to the admin.
	 *
	 * @return showpending view
	 */
	public function pendingEdit()
	{
		$user = Session::get('user');
		$suggests = PendingEdit::all();
		
		return view('doctor.pendingSuggest')->with('user',$user)->with('suggests', $suggests);
	}

	/**
	 * Shows the page of a pending Doctor to the admin.
	 *
	 * @return showpending view
	 */
	public function insertPendingEdit()
	{
		$ids = Request::get('pendingid');

		if(Request::get('approve')) {
			foreach ($ids as $key => $value) 
			{
				$this->approveEdit($value);
			}
		}
		else if(Request::get('delete')) {
			foreach ($ids as $key => $value) 
			{
				$this->deleteEdit($value);
			}
		}

		return redirect()->back();
	}

	/**
	 * Shows the page of a pending Doctor to the admin.
	 *
	 * @return showpending view
	 */
	public function approveEdit($id)
	{
		$suggest = PendingEdit::find($id);
		$currentUser = User::find($suggest->user_id);
		$doctor = Doctor::find($suggest->doctor_id);
		$doctorName = $doctor->first_name .' '. $doctor->last_name;

		if($suggest->field == 'edu') {
			Doctor::where('id', $doctor->id)->update(['eduqual' => $suggest->value]);
		}
		if($suggest->field == 'prof') {
			Doctor::where('id', $doctor->id)->update(['profqual' => $suggest->value]);
		}
		if($suggest->field == 'ads') {
			Doctor::where('id', $doctor->id)->update(['address' => $suggest->value]);
		}
		if($suggest->field == 'tele') {
			Doctor::where('id', $doctor->id)->update(['phone' => $suggest->value]);
		}
		if($suggest->field == 'email') {
			Doctor::where('id', $doctor->id)->update(['email' => $suggest->value]);
		}
		if($suggest->field == 'hos') {
			Doctor::where('id', $doctor->id)->update(['hospital' => $suggest->value]);
		}
		if($suggest->field == 'cty') {
			Doctor::where('id', $doctor->id)->update(['city' => $suggest->value]);
		}

		$suggest->delete();

		Mail::send('mailtemplate/suggestApproved', ['name'=> $currentUser->name,'doctor'=> $doctorName], function ($m) use ($currentUser) 
					{
						$m->from('daemon@mail.altairsl.us', 'Daemon');
						$m->to($currentUser->email, $currentUser->name)->subject('Wedaduru Profile Suggestion Notice');
					});
	}

	/**
	 * Shows the page of a pending Doctor to the admin.
	 *
	 * @return showpending view
	 */
	public function deleteEdit($id)
	{
		$suggest = PendingEdit::find($id);
		$currentUser = User::find($suggest->user_id);
		$doctor = Doctor::find($suggest->doctor_id);
		$doctorName = $doctor->first_name .' '. $doctor->last_name;

		$suggest->delete();

		Mail::send('mailtemplate/suggestRejected', ['name'=> $currentUser->name,'doctor'=> $doctorName], function ($m) use ($currentUser) 
					{
						$m->from('daemon@mail.altairsl.us', 'Daemon');
						$m->to($currentUser->email, $currentUser->name)->subject('Wedaduru Profile Suggestion Notice');
					});

		
	}


	/**
	 * Shows the page of a pending Doctor to the admin.
	 *
	 * @return showpending view
	 */
	public function showPendingAppointments()
	{
		$user = Session::get('user');
		$appointments = doctorSchedule::where('did', $user->id)->where('confirmed', 0)->get();

		return view('doctor.pendingAppointments')->with('appointments', $appointments)->with('user',$user);
	}

	/**
	 * Shows the page of a pending Doctor to the admin.
	 *
	 * @return showpending view
	 */
	public function pendingAppointmentAction()
	{
		$ids = Request::get('pendingid');

		if (count($ids) > 0) {
			if(Request::get('confirm')) {
				foreach ($ids as $key => $value) {
					$this->confirmAppointment($value);
				}
			}
			else if(Request::get('cancel')) {
				foreach ($ids as $key => $value) {
					$this->cancelAppointment($value);
				}
			}
		}
		

		return redirect()->back();
	}

	/**
	 * Shows the confirmed apppointments
	 *
	 * @return confirmed appointments view
	 */
	public function showConfirmedAppointments()
	{
		$user = Session::get('user');
		$appointments = doctorSchedule::where('did', $user->id)->where('confirmed', 1)->get();

		return view('doctor.confirmedAppointments')->with('appointments', $appointments)->with('user',$user);
	}

	/**
	 * Takes Relevant action according to appointment
	 *
	 * 
	 */
	public function confirmedAppointmentAction()
	{
		$ids = Request::get('pendingid');

		if(count($ids) > 0) {
			foreach ($ids as $key => $value) {
				$this->cancelAppointment($value);
			}
		}
		
		return redirect()->back();
	}


	/**
	 * Confirm Selected Appointment
	 *
	 * 
	 */
	public function confirmAppointment($id)
	{
		doctorSchedule::where('id', $id)->update(['confirmed' => '1']);

		$schedule = doctorSchedule::find($id);

		$currentDoctor = Doctor::find($schedule->did);
		$doctorName = $currentDoctor->first_name .' '. $currentDoctor->last_name;

		$currentUser = User::find($schedule->uid);

		Mail::send('mailtemplate/appointmentConfirmed', ['name'=> $currentUser->name,'doctor'=> $doctorName], function ($m) use ($currentUser) 
					{
						$m->from('daemon@mail.altairsl.us', 'Daemon');
						$m->to($currentUser->email, $currentUser->name)->subject('Wedaduru Appointment Notice');
					});
    		doctorSchedule::where('id', $value->id)->update(['cancelDoctor' => '1']);
	
	}

	/**
	 * Cancel Selected Appointment
	 *
	 * 
	 */
	public function cancelAppointment($id)
	{
		doctorSchedule::where('id', $id)->update(['cancelDoctor' => '1']);

		$schedule = doctorSchedule::find($id);

		$currentDoctor = Doctor::find($schedule->did);
		$doctorName = $currentDoctor->first_name .' '. $currentDoctor->last_name;

		$currentUser = User::find($schedule->uid);

		Mail::send('mailtemplate/appointmentCancelled', ['name'=> $currentUser->name,'doctor'=> $doctorName], function ($m) use ($currentUser) 
					{
						$m->from('daemon@mail.altairsl.us', 'Daemon');
						$m->to($currentUser->email, $currentUser->name)->subject('Wedaduru Appointment Notice');
					});
    		doctorSchedule::where('id', $value->id)->update(['cancelDoctor' => '1']);
	}

	/**
	 * Shows the page of a pending Doctor to the admin.
	 *
	 * @return showpending view
	 */
	public function updateDoctorReview($id)
	{
		$user = Session::get('user');
		$doctor = Doctor::findOrFail($id);
		$addedRating = Request::get('rating');

		$newRating;

		if ($doctor->rated == 0) {
			$newRating = $addedRating;
			Doctor::where('id', $id)->update(['rated' => 1]); 
		}
		else {
			$newRating = ($doctor->rating + $addedRating) / 2.0;
		}

		Doctor::where('id', $id)->update(['rating' => $newRating]); 

		$userReview = Request::get('review');

		$newReview = new reviews;
		$newReview->user_id = $user->id;
		$newReview->user_name = $user->name;
		$newReview->doctor_id = $doctor->id;
		$newReview->doctor_name = $doctor->first_name . ' '. $doctor->last_name;
		$newReview->review = $userReview;
		$newReview->save();

		return redirect()->back();
	}

	/**
	 * Updates the details of the the Doctor whose ID was passed into the function.
	 *
	 * @return show view
	 */
	public function update($id)
	{
		$specialization = Request::get('spec');
		$notes = Request::get('notes');
		$profqual = Request::get('profqual');
		$eduqual = Request::get('eduqual');
		$hospital = Request::get('hospital');
		$email = Request::get('email');
		$phone = Request::get('phone');
		$address = Request::get('address');
		$city = Request::get('city');

		if(\Input::hasFile('image')) {
			$file = \Input::file('image');
			$format = explode('.', $file->getClientOriginalName());

			$file->move('uploads/profile_pics/doctors', $id . '.' . $format[sizeof($format) - 1]);

			Doctor::where('id', $id)->update(['imagepath' => 'uploads/profile_pics/doctors/' . $id . '.' . $format[sizeof($format) - 1]]);
		}
		if($specialization != null && $specialization != "") {
			Doctor::where('id', $id)->update(['specialization' => $specialization]);
		}
		if($notes != null && $notes != "") {
			Doctor::where('id', $id)->update(['notes' => $notes]);
		}
		if($profqual != null && $profqual != "") {
			Doctor::where('id', $id)->update(['profqual' => $profqual]);
		}
		if($eduqual != null && $eduqual != "") {
			Doctor::where('id', $id)->update(['eduqual' => $eduqual]);
		}
		if($hospital != null && $hospital != "") {
			Doctor::where('id', $id)->update(['hospital' => $hospital]);
		}
		if($email != null && $email != "") {
			Doctor::where('id', $id)->update(['email' => $email]);
		}
		if($phone != null && $phone != "") {
			Doctor::where('id', $id)->update(['phone' => $phone]);
		}
		if($address != null && $address != "") {
			Doctor::where('id', $id)->update(['address' => $address]);
		}
		if($city != null && $city != "") {
			Doctor::where('id', $id)->update(['city' => $city]);
		}


		$current_doctor = Doctor::find($id);

		return redirect()->action('DoctorController@show', $id);
	}

	/**
	 * Selects which action to take depending on whether the admin choosed to Approve the selected requests or to Delete them
	 *
	 */
	public function pendingAction()
	{
		$typeApprove = Request::get('approve');
		$ids = Request::get('pendingid');

		if(Request::get('approve')) {
			foreach ($ids as $key => $value) 
			{
				$this->insertNewPending($value);
			}
		}
		else if(Request::get('delete')) {
			foreach ($ids as $key => $value) 
			{
				$this->deletePending($value);
			}
		}

		return redirect()->back();
	}

	/**
	 * Inserts a currently pending doctor into the Doctors table and deletes that record from the pendingDoctors table.
	 *
	 * @return pendingdoctor view
	 */
	public function insertNewPending($value)
	{
		$doctor = pendingDoctor::find($value);

		$first_name = $doctor->first_name;
		$last_name =  $doctor->last_name;
		$specialization =  $doctor->specialization;
		$notes =  $doctor->notes;
		$profqual =  $doctor->profqual;
		$eduqual =  $doctor->eduqual;
		$hospital =  $doctor->hospital;
		$address =  $doctor->address;
		$email = $doctor->email;
		$phone = $doctor->phone;
		$city = $doctor->city;

		$userToSend = User::find($doctor->user_id);	

		$newDoctor = new Doctor();

		$newDoctor->first_name = $first_name;
		$newDoctor->last_name = $last_name;
		$newDoctor->specialization  = $specialization;
		$newDoctor->notes  = $notes;
		$newDoctor->profqual = $profqual;
		$newDoctor->eduqual = $eduqual;
		$newDoctor->hospital = $hospital;
		$newDoctor->address = $address;
		$newDoctor->city = $city;
		$newDoctor->email = $email;
		$newDoctor->phone = $phone;
		$newDoctor->formal = 0;

		$newDoctor->save();
		$doctor->delete();

		$this->pendingdoctor();

		Mail::send('mailtemplate/doctorApproved', ['name'=> $userToSend->name,'doctor'=>$first_name], function ($m) use ($userToSend) 
					{
						$m->from('daemon@mail.altairsl.us', 'Daemon');
						$m->to($userToSend->email, $userToSend->name)->subject('Wedaduru Doctor Approval');
					});

		return redirect()->back();
	}

	/**
	 * Deletes a currently pending doctor from the pendingDoctors table.
	 *
	 * @return pendingdoctor view
	 */
	public function deletePending($value)
	{
		$doctor = pendingDoctor::find($value);

		$userToSend = User::find($doctor->user_id);	
		$first_name = $doctor->first_name;

		$doctor->delete();

		$doctors = pendingDoctor::all();
		$user = Session::get('user');

		Mail::send('mailtemplate/doctorRejected', ['name'=> $userToSend->name,'doctor'=>$first_name], function ($m) use ($userToSend) 
					{
						$m->from('daemon@mail.altairsl.us', 'Daemon');
						$m->to($userToSend->email, $userToSend->name)->subject('Wedaduru Doctor Approval');
					});
	}

	/**
	 * Adds a new Pending Docotr into the pendingDoctors table.
	 *
	 * @return previous view
	 */
	public function insertNew()
	{
		$input = Request::all();

		$pendingDoctor = new pendingDoctor();

		$pendingDoctor->first_name = Request::get('fname');
		$pendingDoctor->last_name = Request::get('lname');
		$pendingDoctor->specialization = Request::get('spec');
		$pendingDoctor->notes = Request::get('notes');	
		$pendingDoctor->profqual = Request::get('profqual');
		$pendingDoctor->eduqual = Request::get('eduqual');
		$pendingDoctor->hospital = Request::get('hospital');
		$pendingDoctor->address = Request::get('address');
		$pendingDoctor->city = Request::get('city');
		$pendingDoctor->email = Request::get('email');
		$pendingDoctor->phone = Request::get('phone');
		$pendingDoctor->formal = 0;

		//$user = User::find(Session::get('user')->id);	

		$pendingDoctor->user = Session::get('user')->name;
		$pendingDoctor->user_id = Session::get('user')->id; 

		$pendingDoctor->save();

		return redirect()->back();
	}

	/**
	 * Returns view for adding a new Formal Physician
	 *
	 * @return previous view
	 */
	public function newFormalPhysician()
	{
		$user = Session::get('user');

		return View::make('doctor.addformaldoctor')->with('user',$user);
	}

	/**
	 * Returns view for Creating Formal Physician Login
	 *
	 * @return previous view
	 */
	public function doctorCredentials()
	{
		$user = Session::get('user');
		$formalDoctors = Doctor::select(DB::raw("CONCAT(first_name ,' ' ,last_name) AS full_name, id"))->where('formal', 1)->where('has_account', 0)->lists('full_name', 'id');

		return View::make('doctor.doctorcredentials')->with('user',$user)->with('doctors', $formalDoctors);
	}

	/**
	 * Creates account and generates random password for a Formal Physician
	 *
	 * @return previous view
	 */
	public function createDoctorCredentials()
	{
		$doctorID = Request::get('doctors');
		$password = Str::random(10);
		$doctorInfo = Doctor::find($doctorID);

		Doctor::where('id', $doctorID)->update(['has_account' => 1]);
			
		$newUser = new User;
		$newUser->email = $doctorInfo->email;
		$newUser->name = $doctorInfo->first_name . ' ' . $doctorInfo->last_name;
		$newUser->password = md5($password);
		$newUser->tp = $doctorInfo->phone;
		$newUser->level = 2;
		$newUser->active = 1;
		$newUser->verified = 1;

		$newUser->save();

		Mail::send('mailtemplate/doctorPassword', ['name'=> $newUser->name,'password'=>$password], function ($m) use ($newUser) 
					{
						$m->from('daemon@mail.altairsl.us', 'Daemon');
						$m->to($newUser->email, $newUser->name)->subject('Wedaduru Doctor Account');
					});

		return redirect()->back();
	}

	/**
	 * Adds a new Formal Docotr into the Doctors table.
	 *
	 * @return previous view
	 */
	public function insertNewFormal()
	{
		$input = Request::all();

		$newDoctor = new Doctor();

		$newDoctor->first_name = Request::get('fname');
		$newDoctor->last_name = Request::get('lname');
		$newDoctor->specialization = Request::get('spec');
		$newDoctor->notes = Request::get('notes');	
		$newDoctor->profqual = Request::get('profqual');
		$newDoctor->eduqual = Request::get('eduqual');
		$newDoctor->hospital = Request::get('hospital');
		$newDoctor->address = Request::get('address');
		$newDoctor->city = Request::get('city');
		$newDoctor->email = Request::get('email');
		$newDoctor->phone = Request::get('phone');
		$newDoctor->formal = 1;
		$newDoctor->save();
		//$lastEntry = Doctor::orderBy('id', 'DESC')->first();
		//$id = $lastEntry->id + 1;
		$id = $newDoctor->id;
		if(\Input::hasFile('image')) {
			$file = \Input::file('image');
			$format = explode('.', $file->getClientOriginalName());

			$file->move('uploads/profile_pics/doctors', $id . '.' . $format[sizeof($format) - 1]);

			$newDoctor->imagepath = 'uploads/profile_pics/doctors/' . $id . '.' . $format[sizeof($format) - 1];
		}

		$newDoctor->save();

		return redirect()->back();
	}
}
