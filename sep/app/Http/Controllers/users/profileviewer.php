<?php namespace App\Http\Controllers\users;

use App\User;
use App\Doctor;
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

class profileviewer extends Controller
{

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wanted=user::where('id',$id)->first();

        if( is_null($wanted) ){
            return "Not Found";
        }else{
            $doctor=Doctor::where('email','=',$wanted->email)->first();

            if( is_null($doctor) ){
                return view('user.profileview')->with('user',Session::get('user'))->with('viewing',$wanted);
            }else{
                return view('user.profileview')->with('user',Session::get('user'))->with('viewing',$wanted)->with('doctor',$doctor);
            }
            
        }
        
    }
}
