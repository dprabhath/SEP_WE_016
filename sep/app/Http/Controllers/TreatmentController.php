<?php namespace App\Http\Controllers;

use App\Doctor;
use App\Treatment;
use App\pendingTreatment;
use App\DoctorTreatment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Request;
use Session;

class TreatmentController extends Controller {

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
	 * Shows the Treatment List to the user.
	 *
	 * @return index view
	 */
	public function index()
	{
		$treatments = DoctorTreatment::all();
		$user = Session::get('user');

		return view('treatment.index')->with('treatments', $treatments)->with('user',$user);
	}

	/**
	 * Shows the page of a specific Treatment to the user.
	 *
	 * @return show view
	 */
	public function show($id)
	{
		$treatment = DoctorTreatment::findOrFail($id);
		$user = Session::get('user');
		$doctor = Doctor::findOrFail($treatment->doctor_id);

		$image1 = 1;
		$image2 = 1;
		$image3 = 1;
		$image4 = 1;

		if($treatment->image1 == 'NONE')
			$image1 = 0;
		if($treatment->image2 == 'NONE')
			$image2 = 0;
		if($treatment->image3 == 'NONE')
			$image3 = 0;
		if($treatment->image4 == 'NONE')
			$image4 = 0;

		return View::make('treatment.show')->with('treatment', $treatment)->with('user',$user)->with('image1',$image1)->with('image2',$image2)->with('image3',$image3)->with('image4',$image4)->with('doctor', $doctor);
	}

	/**
	 * Shows the page for adding a new Treatment to the user.
	 *
	 * @return newtreatment view
	 */
	public function newTreatment()
	{
		$user = Session::get('user');
		return View::make('treatment.newtreatment')->with('user',$user)->with('message', '');
	}

	/**
	 * Shows the page for approving and deleting new New Treatment Requests to the admin.
	 *
	 * @return pendingtreatment view
	 */
	public function pendingTreatment()
	{
		$treatments = pendingTreatment::all();
		$user = Session::get('user');

		return View::make('treatment.pending')->with('treatments', $treatments)->with('user',$user);
	}

	/**
	 * Shows the details of a pending Treatment to the admin.
	 *
	 * @return showpending view
	 */
	public function showPendingTreatment($id)
	{
		$treatment = pendingTreatment::find($id);
		$user = Session::get('user');

		return View::make('treatment.showpending')->with('treatment', $treatment)->with('user',$user);
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
	 * Inserts new Treatment into Treatments table and deletes that record from the Pending Treatments table
	 *
	 */
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

	/**
	 * Deletes Treatment from Pending Treatments table
	 *
	 */
	public function deletePending($value)
	{
		$treatment = pendingTreatment::find($value);
		$treatment->delete();
	}

	/**
	 * Inserts a new Treatment into the Pending Treatments table
	 *
	 */
	public function insertNew()
	{
		$input = Request::all();
		$user = Session::get('user');

		$Treatment = new DoctorTreatment;

		$Treatment->name = Request::get('tname');
		$Treatment->doctor_id = $user->id;
		$Treatment->description = Request::get('description');
		$Treatment->conditions1 = Request::get('wsigns');
		$Treatment->conditions2 = Request::get('condition');

		$Treatment->save();



		if(\Input::hasFile('image1')) {
			$file = \Input::file('image1');
			$format = explode('.', $file->getClientOriginalName());

			$filepath = 'uploads/treatments/'. $Treatment->id . '-1.' . $format[sizeof($format) - 1];
			$file->move('uploads/treatments', $Treatment->id . '-1.' . $format[sizeof($format) - 1]);

			$Treatment->image1 = Request::get('image1');
			DoctorTreatment::where('id', $Treatment->id)->update(['image1' => $filepath]);
		}

		if(\Input::hasFile('image2')) {
			$file = \Input::file('image2');
			$format = explode('.', $file->getClientOriginalName());

			$filepath = 'uploads/treatments/'. $Treatment->id . '-2.' . $format[sizeof($format) - 1];

			$file->move('uploads/treatments', $Treatment->id . '-2.' . $format[sizeof($format) - 1]);

			$Treatment->image1 = Request::get('image2');
			DoctorTreatment::where('id', $Treatment->id)->update(['image2' => $filepath]);
		}

		if(\Input::hasFile('image3')) {
			$file = \Input::file('image3');
			$format = explode('.', $file->getClientOriginalName());

			$filepath = 'uploads/treatments/'. $Treatment->id . '-3.' . $format[sizeof($format) - 1];

			$file->move('uploads/treatments', $Treatment->id . '-3.' . $format[sizeof($format) - 1]);

			$Treatment->image1 = Request::get('image3');
			DoctorTreatment::where('id', $Treatment->id)->update(['image3' => $filepath]);
		}
		
		if(\Input::hasFile('image4')) {
			$file = \Input::file('image4');
			$format = explode('.', $file->getClientOriginalName());

			$filepath = 'uploads/treatments/'. $Treatment->id . '-4.' . $format[sizeof($format) - 1];

			$file->move('uploads/treatments', $Treatment->id . '-4.' . $format[sizeof($format) - 1]);

			$Treatment->image1 = Request::get('image4');
			DoctorTreatment::where('id', $Treatment->id)->update(['image4' => $filepath]);
		}

		$treatments = Treatment::all();

		return redirect()->back()->with('message', 'Successfully Entered!');
	}



}
