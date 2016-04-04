@extends('template/template_user')
	
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

    
    <?php 
      $ratingString;

      if($doctor->rating > 8)
        $ratingString = 'Excellent';
      else if($doctor->rating > 5)
        $ratingString = 'Good';
      else if($doctor->rating == 5)
        $ratingString = 'Average';
      else if($doctor->rating < 5)
        $ratingString = 'Below Average';

    ?>


    <div class="panel panel-default bg-custom">
        <div class="panel-body">
            <div class="p-l-10 p-r-10 p-t-10 p-b-15">
              <div class="panel-footer">
                <h2><span class="semi-bold">Doctor Profile</span></h2>
              </div>
                
                <div class="row" style="padding-top:30px">
                    <div class="col-sm-3" style="padding-bottom:20px">
                        <img class="img-circle big-profile-pic p-t-10" alt="" src="{{ url('/') }}/{!! $doctor->imagepath !!}"  width="200" height="200">

                    </div>
                    <div class="col-sm-9">
                      <div class="col-sm-8">
                        <h5 class="semi-bold">Dr {!! $doctor->first_name !!} {!! $doctor->last_name !!}</h5>

                        <p class="no-margin"  style="padding-top:40px">Specialization : {!! $doctor->specialization!!} </p>

                        <p class="no-margin">Doctor Notes : {!! $doctor->notes!!} </p>

                        <p class="no-margin"  style="padding-top:40px">User Rating : {!! $ratingString !!} </p>
                        </div>
                        <div class="col-sm-4">
                        @if( $doctor->available==1 )
                       <button type="button" onclick="NavigateTo('{{ url('/') }}/setappointment-user/{!! $doctor->id!!}')" class="btn btn-primary">Make An Apointment</button>
                       @else
                        <button type="button" class="btn btn-danger">Not Available for Apointment</button>
                       @endif
                        </div>
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
                <div  class="panel-footer">
                  <h3><span class="semi-bold"> User Comments </span></h3>
                </div>
                <div class="wid_blog" >
                  @foreach ($reviews as $review)
                              <h1> {!!  $review->review !!} </h1>
                              <h3> {!!  $review->user_name !!} </h3>
                  @endforeach 
                </div>
                <input class="btn btn_5 btn-lg btn-info" type="submit" value="Back" onclick="NavigateTo('../doctors')">
                <input class="btn btn_5 btn-lg btn-info" value="Rate and Comment" onclick="NavigateTo('review/{!! $doctor->id!!}')">
                @if($user->level>4)
                <input class="btn btn_5 btn-lg btn-info" value="Edit" onclick="NavigateTo('edit/{!! $doctor->id!!}')">
                @endif
    </div>

        
    
@stop

@section('footer')
@stop