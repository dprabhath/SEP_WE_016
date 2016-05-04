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

<div class="panel-body1">
        <div  class="panel-footer">
            <h3><span class="semi-bold"> Physician Rating : Dr.{!! $doctor->first_name !!} {!! $doctor->last_name !!} : {!! $ratingString !!}</span></h3>
        </div>
        <div class="tab-content">
                        <div class="tab-pane active" id="horizontal-form">
                             {!! Form::open(array('class' => 'form-horizontal', 'files' => true, 'name' => 'editForm', 'onsubmit' => 'return validateForm()')) !!} 
                             	<div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Your Rating : </label>
                                    <div class="col-sm-8"> 
                                    	{!! Form::select('rating', ['9' => 'Excellent', '7' => 'Good', '5' => 'Average','3' => 'Below Average'], null, ['class' => 'form-control1']) !!}
                                    </div>
                                </div>       
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Comments : </label>
                                    <div class="col-sm-8"> 
                                    	 {!! Form::textarea('review', null,  [ 'class' => 'form-control1', 'style' => 'height:100px', 'id' => 'review']) !!}
                                    </div>
                                </div>
                        </div>
                        <div class="panel-footer">
	                      <div class="row">
	                          <div class="col-sm-8 col-sm-offset-2">
	                               {!! Form::submit('Submit', ['class' => 'btn btn_5 btn-lg btn-info']) !!}  
	                              <input type="button "class="btn btn_3 btn-lg btn-info" value="Back" onclick="NavigateTo('../../doctors/{{ $doctor->id }}')">
	                              {!! Form::close() !!}
	                          </div>
	                      </div>
                    	</div>
        </div>
</div>

<div class="panel-body1">
		<div  class="panel-footer">
            <h3><span class="semi-bold"> User Comments </span></h3>
        </div>
          @if(count($reviews) > 0)
   		    <div class="wid_blog" >
            @foreach ($reviews as $review)
                        <h1> {!!  $review->review !!} </h1>
                        <h3> {!!  $review->user_name !!} </h3>
            @endforeach 
          </div>
          @else
                <div class="wid_blog" >
                  <h2><span class="semi-bold"> No Reviews Yet! </span></h2>
                </div>
          @endif
</div>
        
    
@stop

@section('footer')
@stop