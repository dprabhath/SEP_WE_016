@extends('template/template_user')
	
@section('head')

@stop

@section('navbar')
@stop
	
		
@section('body')


    <div class="panel panel-default bg-custom">
        <div class="panel-body">
            <div class="p-l-10 p-r-10 p-t-10 p-b-15">
              <div class="panel-footer">
                <h2><span class="semi-bold">Doctor Profile</span></h2>
              </div>
                
                <div class="row" style="padding-top:30px">
                    <div class="col-sm-3" style="padding-bottom:20px">
                        <img class="img-circle big-profile-pic p-t-10" alt="" src="http://placehold.it/300x200"  width="200" height="200">

                    </div>
                    <div class="col-sm-9">
                        <h5 class="semi-bold">Dr {!! $doctor->first_name !!} {!! $doctor->last_name !!}</h5>

                        <p class="no-margin"  style="padding-top:40px">Specialization : {!! $doctor->specialization!!} </p>

                        <p class="no-margin">Doctor Notes : {!! $doctor->notes!!} </p>

                        <p class="no-margin"  style="padding-top:40px">User Rating : {!! $doctor->rating!!} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-body1">
        <div class="table-responsive">
          <table class="table">
           
            <tbody>
              <tr>
                <td style="width:130px; font-weight:bold;" > Professional Qualifications</td>
                <td style="width:500px">: {!! $doctor->profqual!!}</td>
               
              </tr>
              <tr>
                <td class="breadcrumb" style="font-weight:bold"> Educational Qualifications</td>
                <td class="breadcrumb">: {!! $doctor->eduqual!!}</td>
              </tr>
              <tr >
                <td style="font-weight:bold"> Hospital</td>
                <td>: {!! $doctor->hospital!!}</td>
              </tr>
              <tr>
                <td  class="breadcrumb" style="font-weight:bold"> Telephone</td>
                <td  class="breadcrumb">: {!! $doctor->phone!!}</td>
              </tr>
              <tr>
                <td style="font-weight:bold"> Email</td>
                <td>: {!! $doctor->email!!}</td>
              </tr>
              <tr>
                <td class="breadcrumb" style="font-weight:bold"> Address</td>
                <td class="breadcrumb">: {!! $doctor->address!!}</td>
              <tr>
              
                <!--tr>
                <td>  <a href="#" onclick="history.back()" class="btn btn_5 btn-lg btn-info" style="margin-top:20px">Back</a></td>
                <td></td>
              </tr-->
            </tbody>
          </table>
          </div>
    </div>
    <div class="panel-body1">
                <div class="wid_blog" >
                <h2> User Comments </h2>
                    <h1>" Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's "</h1>
                    <h3> Username </h3>
                    <h1 style="padding-top:10px">" Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's "</h1>
                    <h3> Username </h3>
                </div>
    </div>
        
    
@stop

@section('footer')
@stop