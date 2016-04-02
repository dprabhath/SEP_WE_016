@extends('template/template_user')
@section('head')
<link href="{{ url('/') }}/resources/apointment/themes/css-stars.css" rel="stylesheet">
<script src="{{ url('/') }}/resources/apointment/jquery.barrating.min.js"></script>

<script type="text/javascript">
	
	$( document ).ready(function() {
  
  		@if(! empty($doctor) )
		@if( $doctor->rating!=0.0 )
		$('#example').barrating({
        		theme: 'css-stars',
        		hoverState: false
      		});

		$('#example').barrating('readonly', true);
		$('#example').barrating('set', {{ (int) $doctor->rating }});
		@endif
		@endif
	});


</script>


@stop
@section('navbar')
@stop


@section('body')
<div class="row">
	<div class="col-sm-12">
	<div class="tab-pane fade in active r3_counter_box">

		@if(! empty($doctor) )
		<div class="row">
		<div class="col-sm-3 container-fluid" align="center">
	 		@if($userReq->pic!='')
						<img src={{ url('/') }}/{{$userReq->pic}} class="img-thumbnail" alt="Cinque Terre" width="304" height="236" id="profile_pic">

						@else
						<img src="{{ url('/') }}/uploads/profile_pics/emp.png" class="img-thumbnail" alt="Cinque Terre" width="304" height="236" id="profile_pic">
						@endif
	 	</div>
	 	<div class="col-sm-9">
	 		<div class="form-horizontal">
  				<div class="form-group">
    			<label class="col-sm-2 control-label">Name</label>
			    <div class="col-sm-10">
			      <p class="form-control-static">{{ $doctor->first_name }} {{ $doctor->last_name }}</p>
			    </div>
  			</div>
  			</div>

			<div class="form-horizontal">
  				<div class="form-group">
    			<label class="col-sm-2 control-label">Specialization</label>
			    <div class="col-sm-10">
			      <p class="form-control-static">{{ $doctor->specialization }}</p>
			    </div>
  			</div>
  			</div>

  			<div class="form-horizontal">
  				<div class="form-group">
    			<label class="col-sm-2 control-label">Phone</label>
			    <div class="col-sm-10">
			      <p class="form-control-static">{{ $doctor->phone }}</p>
			    </div>
  			</div>
  			</div>

  			<div class="form-horizontal">
  				<div class="form-group">
    			<label class="col-sm-2 control-label">Rating</label>
			    <div class="col-sm-10">
			    @if( $doctor->rating==0.0 )
			    	<p class="form-control-static">Not Available</p>
			    @else
			      <select class="form-control-static" id="example">
  					<option value="1" data-html="good">1</option>
  					<option value="2" data-html="good">2</option>
  					<option value="3" data-html="good">3</option>
  					<option value="4" data-html="good">4</option>
  					<option value="5" data-html="good">5</option>
				 </select>
			      @endif
			    </div>
  			</div>
  			</div>

	 	</div>
	 	
	 	</div>
	 	<!-- schedule shower -->
	 	<div class="row">

	 	</div>
	 	@else
	 		Doctor is not found!
	 	@endif



	</div>
	</div>
</div>
@stop

@section('footer')
@stop