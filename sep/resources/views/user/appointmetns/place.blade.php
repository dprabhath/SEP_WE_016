@extends('template/template_user')
@section('head')
<link href="{{ url('/') }}/resources/apointment/themes/css-stars.css" rel="stylesheet">
<script src="{{ url('/') }}/resources/apointment/jquery.barrating.min.js"></script>
<link href="{{ url('/') }}/resources/apointment/jqueryui/jquery-ui.css" rel="stylesheet">
<script src="{{ url('/') }}/resources/apointment/jqueryui/jquery-ui.js"></script>

<style type="text/css">
	#selectable-7 .ui-selecting { background: #707070 ; }
    #selectable-7 .ui-selected { background: #2E8DEF; color: #FFFFFF; }
    
    #timeslotshow td,th,caption{
    	text-align:center; 
    	vertical-align:middle;
    }
    #timeslotcol{
    	padding-top:50px;
    }

</style>

<script type="text/javascript">
var selectedslot="";
function profile(url){
	window.open(url);
}
	
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

		$( "#selectable-7" ).selectable({
			   filter:'.tdselect',
               selected: function( event, ui ) {
               		var s=$(this).find('.ui-selected');
            		//alert(s.html());
            		console.log(s.html());
            		selectedslot=s.html();
               },
               selecting: function(event, ui){
            		if( $(".ui-selected, .ui-selecting").length > 1){
                  		$(ui.selecting).removeClass("ui-selecting");
            		}
      			},
      			unselecting: function( event, ui ) {
            		console.log("unselecting");
            		selectedslot="";
      			}
            });
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
		<div class="col-sm-2 container-fluid" align="center">
	 		@if($userReq->pic!='')
						<img src={{ url('/') }}/{{$userReq->pic}} class="img-thumbnail" alt="Cinque Terre" width="304" height="236" id="profile_pic">

						@else
						<img src="{{ url('/') }}/uploads/profile_pics/emp.png" class="img-thumbnail" alt="Cinque Terre" width="304" height="236" id="profile_pic">
						@endif
	 	</div>
	 	<div class="col-sm-6 container-fluid">
	 		<div class="form-horizontal">
  				<div class="form-group">
    			<label class="col-sm-4 control-label">Name</label>
			    <div class="col-sm-8">
			      <p class="form-control-static">{{ $doctor->first_name }} {{ $doctor->last_name }}</p>
			    </div>
  			</div>
  			</div>

			<div class="form-horizontal">
  				<div class="form-group">
    			<label class="col-sm-4 control-label">Specialization</label>
			    <div class="col-sm-8">
			      <p class="form-control-static">{{ $doctor->specialization }}</p>
			    </div>
  			</div>
  			</div>

  			<div class="form-horizontal">
  				<div class="form-group">
    			<label class="col-sm-4 control-label">Phone</label>
			    <div class="col-sm-8">
			      <p class="form-control-static">{{ $doctor->phone }}</p>
			    </div>
  			</div>
  			</div>

  			<div class="form-horizontal">
  				<div class="form-group">
    			<label class="col-sm-4 control-label">Rating</label>
			    <div class="col-sm-8">
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
	 	<div class="col-sm-4 container-fluid">
	 		<div class="form-horizontal">
  				<div class="form-group">
    			<label class="col-sm-4 control-label">Address</label>
			    <div class="col-sm-8">
			      <p class="form-control-static">{{ $doctor->address }}</p>
			    </div>
  			</div>
  			</div>
  			<div class="form-horizontal">
  				<div class="form-group">
    			<label class="hidden-sm col-xs-2  control-label"></label>
			    <div class="col-sm-12 col-xs-8">
			      <button onclick="profile('{{ url('/') }}/user/{{$userReq->id}}')" type="submit" class="btn btn-info btn-block">More Info</button>
			    </div>
			    <label class="hidden-sm col-xs-2  control-label"></label>
  			</div>
  			</div>
	 	</div>
	 	
	 	</div>
	 	<!-- schedule shower -->
	 	<div class="row">
	 	<div class="col-sm-12" id="timeslotcol">
		 	<div class="table-responsive">
  			<table class="table table-striped" id="timeslotshow">
    			<caption>Available TimeSlots</caption>
    			<thead>
    				<th>2016/03/02</th>
    				<th>2016/03/03</th>
    				<th>2016/03/04</th>
    				<th>2016/03/05</th>
    				<th>2016/03/06</th>
    				<th>2016/03/07</th>
    				<th>2016/03/08</th>
    			</thead>
    			<tbody id="selectable-7">
    				<tr>
    					<td class="tdselect">8.30-9.00</td>
    					<td class="tdselect">8.30-9.00</td>
    					<td class="tdselect">8.30-9.00</td>
    					<td class="tdselect">8.30-9.00</td>
    					<td class="tdselect">8.30-9.00</td>
    					<td class="tdselect">8.30-9.00</td>
    					<td class="tdselect">8.30-9.00</td>

    				</tr>
    				<tr>
    					<td class="tdselect">9.00-9.30</td>
    					<td class="tdselect">9.00-9.30</td>
    					<td class="tdselect">9.00-9.30</td>
    					<td class="tdselect">9.00-9.30</td>
    					<td class="tdselect">9.00-9.30</td>
    					<td></td>
    					<td class="tdselect">9.00-9.30</td>
    				</tr>
    				<tr>
    					<td class="tdselect">9.30-10.00</td>
    					<td class="tdselect">9.30-10.00</td>
    					<td ></td>
    					<td></td>
    					<td></td>
    					<td class="tdselect">9.30-10.00</td>
    					<td class="tdselect">9.30-10.00</td>
    				</tr>
    			</tbody>
  			</table>
		</div>
		</div>
	 	</div>
	 	<div class="row">
	 	<div class="col-sm-12">
	 		<div class="form-horizontal">
  				<div class="form-group">
    			<div class="col-sm-3 col-xs-1"></div>
			    <div class="col-sm-6 col-xs-10">
			      <button type="submit" class="btn btn-info btn-block">Make an Appointment</button>
			    </div>
			    <div class="col-sm-3 col-xs-1">
			    	
			    </div>
  			</div>
  			</div>
	 	</div>
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