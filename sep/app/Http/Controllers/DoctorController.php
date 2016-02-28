<?php namespace App\Http\Controllers;

use App\Doctor;
use App\pendingDoctor;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Request;

class DoctorController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$doctors = Doctor::all();

		return view('doctor.index')->with('doctors', $doctors);
		//return $doctors;
	}

	public function show($id)
	{
		$doctor = Doctor::findOrFail($id);

		return View::make('doctor.show')->with('doctor', $doctor);
	}

	public function newdoctor()
	{
		return View::make('doctor.newdoctor');
	}

	public function pendingdoctor()
	{
		$doctors = pendingDoctor::all();

		return View::make('doctor.pendingdoctor')->with('doctors', $doctors);;
	}

	public function edit($id)
	{
		$doctor = Doctor::findOrFail($id);


		return view('doctor.edit')->with('doctor', $doctor);
	}

	public function showPending($id)
	{
		$doctor = pendingDoctor::findOrFail($id);

		return view('doctor.showpending')->with('doctor', $doctor);
	}

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

		if(\Input::hasFile('image'))
		{
			$file = \Input::file('image');
			$format = explode('.', $file->getClientOriginalName());

			$file->move('uploads/profile_pics/doctors', $id . '.' . $format[sizeof($format) - 1]);

			Doctor::where('id', $id)->update(['imagepath' => 'uploads/profile_pics/doctors/' . $id . '.' . $format[sizeof($format) - 1]]);
		}
		if($specialization != null && $specialization != "")
		{
			Doctor::where('id', $id)->update(['specialization' => $specialization]);
		}
		if($notes != null && $notes != "")
		{
			Doctor::where('id', $id)->update(['notes' => $notes]);
		}
		if($profqual != null && $profqual != "")
		{
			Doctor::where('id', $id)->update(['profqual' => $profqual]);
		}
		if($eduqual != null && $eduqual != "")
		{
			Doctor::where('id', $id)->update(['eduqual' => $eduqual]);
		}
		if($hospital != null && $hospital != "")
		{
			Doctor::where('id', $id)->update(['hospital' => $hospital]);
		}
		if($email != null && $email != "")
		{
			Doctor::where('id', $id)->update(['email' => $email]);
		}
		if($phone != null && $phone != "")
		{
			Doctor::where('id', $id)->update(['phone' => $phone]);
		}
		if($address != null && $address != "")
		{
			Doctor::where('id', $id)->update(['address' => $address]);
		}


		$current_doctor = Doctor::find($id);

		return view('doctor.show')->with('doctor', $current_doctor);
	}

	public function pendingAction()
	{
		$typeApprove = Request::get('approve');
		$ids = Request::get('pendingid');

		if(Request::get('approve'))
		{
			foreach ($ids as $key => $value) 
			{
				$this->insertNewPending($value);
			}
		}
		else if(Request::get('delete'))
		{
			foreach ($ids as $key => $value) 
			{
				$this->deletePending($value);
			}
		}
	}

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

		$newDoctor->save();
		$doctor->delete();
	}

	public function deletePending($value)
	{
		$doctor = pendingDoctor::find($value);
		$doctor->delete();
	}

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

		$pendingDoctor->save();
	}



}
