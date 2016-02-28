<?php namespace App\Http\Controllers;

use App\Doctor;
use App\Treatment;
use App\pendingTreatment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Request;

class TreatmentController extends Controller {

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
		$treatments = Treatment::all();

		return view('treatment.index')->with('treatments', $treatments);
		//return $doctors;
	}

	public function show($id)
	{
		$treatment = Treatment::findOrFail($id);

		return View::make('treatment.show')->with('treatment', $treatment);
	}

	public function newtreatment()
	{
		return View::make('treatment.new');
	}

	public function pendingTreatment()
	{
		$treatments = pendingTreatment::all();

		return View::make('treatment.pending')->with('treatments', $treatments);;
	}

	public function showPendingTreatment($id)
	{
		$treatment = pendingTreatment::find($id);

		return View::make('treatment.showpending')->with('treatment', $treatment);;
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

			$file->move('uploads/profile_pics', $id . '.' . $format[sizeof($format) - 1]);

			Doctor::where('id', $id)->update(['imagepath' => 'uploads/profile_pics/' . $id . '.' . $format[sizeof($format) - 1]]);
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
		$treatment = pendingTreatment::find($value);

		$name = $treatment->name;
		$description =  $treatment->description;
		

		$newTreatment = new Treatment;

		$newTreatment->name = $name;
		$newTreatment->description = $description;
		
		echo $newTreatment;

		$newTreatment->save();
		$treatment->delete();
	}

	public function deletePending($value)
	{
		$treatment = pendingTreatment::find($value);
		$treatment->delete();
	}

	public function insertNew()
	{
		$input = Request::all();

		$pendingTreatment = new pendingTreatment;

		$pendingTreatment->name = Request::get('name');
		$pendingTreatment->description = Request::get('desc');
		

		$pendingTreatment->save();

		$treatments = Treatment::all();

		return view('treatment.index')->with('treatments', $treatments);
	}



}
