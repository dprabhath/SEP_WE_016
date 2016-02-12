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
		$doctors = Doctor::all();

		return View::make('doctor.pendingdoctor')->with('doctors', $doctors);;
	}

	public function edit($id)
	{
		$doctor = Doctor::findOrFail($id);


		return view('doctor.edit')->with('doctor', $doctor);
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

	public function insertNew()
	{
		$input = Request::all();

		$pendingdoctor = new pendingDoctor;

		$pendingdoctor->first_name = Request::get('fname');
		$pendingdoctor->last_name = Request::get('lname');
		$pendingdoctor->specialization = Request::get('spec');
		$pendingdoctor->notes = Request::get('notes');	
		$pendingdoctor->profqual = Request::get('profqual');
		$pendingdoctor->eduqual = Request::get('eduqual');
		$pendingdoctor->hospital = Request::get('hospital');
		$pendingdoctor->address = Request::get('address');
		$pendingdoctor->email = Request::get('email');
		$pendingdoctor->phone = Request::get('phone');

		$pendingdoctor->save();
	}



}
