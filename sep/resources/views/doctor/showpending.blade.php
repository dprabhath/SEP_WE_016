@extends('admintemplate/template_admin')
	
@section('head')

<script type="text/javascript">

    function NavigateTo(theUrl)
    {
      document.location.href = theUrl;
    }

</script>



@stop

@section('navbar')
@stop
	
		
@section('body')


<div class="col-md-12 inbox_right">
          <div class="Compose-Message">               
                <div class="panel panel-default">
                    <div class="panel-heading" >
                        <h3><span class="semi-bold">Pending Physician Details : {!! $doctor->first_name !!} {!! $doctor->last_name !!}</span></h3>
                    </div>
                    <div class="grid_3 grid_5">
                    
                        <div class="but_list">
           
                          <div class="well">
                              Added by {!! $doctor->user!!} on {!! $doctor->created_at!!}
                          </div>
           
                        </div>
                        <div class="table-responsive">
                          <table class="table">
                           
                            <tbody>
                              <tr>
                                <td style="font-weight:bold"> Specialization</td>
                                <td >: {!! $doctor->specialization !!}</td>
                              </tr>
                              <tr >
                                <td class="breadcrumb" style="font-weight:bold"> Notes </td>
                                <td class="breadcrumb">: {!! $doctor->notes !!}</td>
                              </tr>
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
                            </tbody>
                          </table>
                          <input class="btn btn_5 btn-lg btn-info" type="submit" value="Back" onclick="NavigateTo('../pending')">
                        </div>
                    </div>
                      
                 </div>
              </div>
         </div>
  

@stop

@section('footer')
@stop