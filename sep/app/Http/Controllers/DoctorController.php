<?php namespace App\Http\Controllers;

use App\Doctor;
use App\user;
use App\pendingDoctor;
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

class DoctorController extends Controller {

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
	 * Returns view consisting of the list of approved Informal Physicians
	 *
	 * @return newdoctor view
	 */
	public function approvedList()
	{
		$user = Session::get('user');
		$doctors = Doctor::all()->where('formal', 0);

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

		$userToSend = User::find($doctor->user_id);	

		$newDoctor = new Doctor;

		$newDoctor->first_name = $first_name;
		$newDoctor->last_name = $last_name;
		$newDoctor->specialization  = $specialization;
		$newDoctor->notes  = $notes;
		$newDoctor->profqual = $profqual;
		$newDoctor->eduqual = $eduqual;
		$newDoctor->hospital = $hospital;
		$newDoctor->address = $address;
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

		$pendingDoctor = new pendingDoctor;

		$pendingDoctor->first_name = Request::get('fname');
		$pendingDoctor->last_name = Request::get('lname');
		$pendingDoctor->specialization = Request::get('spec');
		$pendingDoctor->notes = Request::get('notes');	
		$pendingDoctor->profqual = Request::get('profqual');
		$pendingDoctor->eduqual = Request::get('eduqual');
		$pendingDoctor->hospital = Request::get('hospital');
		$pendingDoctor->address = Request::get('address');
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
		$newUser->level = 5;

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

		$newDoctor = new Doctor;

		$newDoctor->first_name = Request::get('fname');
		$newDoctor->last_name = Request::get('lname');
		$newDoctor->specialization = Request::get('spec');
		$newDoctor->notes = Request::get('notes');	
		$newDoctor->profqual = Request::get('profqual');
		$newDoctor->eduqual = Request::get('eduqual');
		$newDoctor->hospital = Request::get('hospital');
		$newDoctor->address = Request::get('address');
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
