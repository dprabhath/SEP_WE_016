<?php namespace App\Http\Controllers;

use App\Doctor;
use App\Treatment;
use App\pendingTreatment;
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
		$this->middleware('AdminloginCheck');
	}

	/**
	 * Shows the Treatment List to the user.
	 *
	 * @return index view
	 */
	public function index()
	{
		$treatments = Treatment::all();
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
		$treatment = Treatment::findOrFail($id);
		$user = Session::get('user');

		return View::make('treatment.show')->with('treatment', $treatment)->with('user',$user);
	}

	/**
	 * Shows the page for adding a new Treatment to the user.
	 *
	 * @return newtreatment view
	 */
	public function newTreatment()
	{
		$user = Session::get('user');
		return View::make('treatment.new')->with('user',$user)->with('message', '');
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

		$pendingTreatment = new pendingTreatment;

		$pendingTreatment->name = Request::get('name');
		$pendingTreatment->description = Request::get('desc');
		$pendingTreatment->user = $user->name;

		$pendingTreatment->save();

		$treatments = Treatment::all();

		return redirect()->back()->with('message', 'Successfully Entered!');
	}



}
