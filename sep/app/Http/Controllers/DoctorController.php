<?php namespace App\Http\Controllers;

use App\Doctor;
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

	public function edit($id)
	{
		$doctor = Doctor::findOrFail($id);


		return view('doctor.edit')->with('doctor', $doctor);
	}

	public function sortfilter()
	{
		$filter_location = Request::get('location');
		$filter_specialization = Request::get('spec');
		$sort_type = Request::get('sorttype');

		if($sort_type == 'rating')
		{
			if($filter_location == 'all')
			{
				if($filter_specialization == 'all')
				{
					$results = Doctor::orderBy($sort_type, 'desc')->get();
				}
				else
				{
					$results = Doctor::where('specialization', $filter_specialization)->orderBy($sort_type, 'desc')->get();
				}
			}
			else
			{
				if($filter_specialization == 'all')
				{
					$results = Doctor::where('location', $filter_location)->orderBy($sort_type, 'desc')->get();
				}
				else
				{
					$results = Doctor::where('location', $filter_location)->where('specialization', $filter_specialization)->orderBy($sort_type, 'desc')->get();
				}
			}
		}
		else
		{
			if($filter_location == 'all')
			{
				if($filter_specialization == 'all')
				{
					$results = Doctor::orderBy($sort_type, 'asc')->get();
				}
				else
				{
					$results = Doctor::where('specialization', $filter_specialization)->orderBy($sort_type, 'asc')->get();
				}
			}
			else
			{
				if($filter_specialization == 'all')
				{
					$results = Doctor::where('location', $filter_location)->orderBy($sort_type, 'asc')->get();
				}
				else
				{
					$results = Doctor::where('location', $filter_location)->where('specialization', $filter_specialization)->orderBy($sort_type, 'asc')->get();
				}
			}
		}
		
		return view('doctor.index')->with('doctors', $results);
	}

	public function update($id)
	{
		$specialization = Request::get('spec');
		$location = Request::get('loc');

		Doctor::where('id', $id)->update(['location' => $location]);
		Doctor::where('id', $id)->update(['specialization' => $specialization]);

		$current_doctor = Doctor::find($id);

		return view('doctor.show')->with('doctor', $current_doctor);
	}



}
