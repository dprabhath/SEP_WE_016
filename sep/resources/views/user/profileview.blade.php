@extends('template/template_user')

@section('head')
<link href="{{ url('/') }}/resources/user_profile/bootstrap-toggle.min.css" rel="stylesheet">
<script src="{{ url('/') }}/resources/user_profile/bootstrap-toggle.min.js"></script>
<style type="text/css">

	.fa-spinner {

		margin-top:-12px !important;
		margin-right:-12px !important;
	}
	@media (max-width: 768px) {
		/* For mobile phones: */
		.fa-spinner {

			margin-top:-6px !important;
			margin-right:-12px !important;

		}

	}

	.toggle.android { width: 100%;}
</style>
<script type="text/javascript">
	const token = "{{ csrf_token() }}";
	/*************************REGEX Checks*******************************/
	
$(document).ready(function(){

	@if(! empty($doctor) )

		@if( $doctor->available==0 )
    		$('#toggle-two').bootstrapToggle('off');
    	@else
    		$('#toggle-two').bootstrapToggle('on');
    	@endif
    	$('#toggle-two').bootstrapToggle('disable');
    @endif


	
});


</script>
@stop

@section('navbar')
@stop


@section('body')

<div class="row">
	<div class="col-md-4">

		<div class="list-group list-group-alternate"> 
			<a data-toggle="tab" href="#home" class="list-group-item"><i class="ti ti-email"></i> Profile </a> 
			@if(! empty($doctor) )
				<a class="list-group-item"><span class="badge badge-warning">{{$doctor->rating}}</span>Rating </a> 
				<a class="list-group-item" id='available'>
				
				<input type="checkbox" checked data-toggle="toggle" id="toggle-two" data-on="Available for Appointments" data-off="Not Available for Appointments" data-offstyle="danger" data-style="android" >
				
				 </a> 
			@endif
			
			<a data-toggle="tab" href="#menu1" class="list-group-item"><span class="badge badge-warning">14</span> Posts created </a>
			<a data-toggle="tab" href="#menu1" class="list-group-item"><span class="badge badge-warning">100</span>Contributions </a> 
			<a data-toggle="tab" href="#menu1" class="list-group-item"><span class="badge badge-warning">14</span> Messages </a> 
			<a data-toggle="tab" href="#menu1" class="list-group-item"><span class="badge badge-danger">30</span>Notifications </a> 
		</div>
	</div>
	<div class="col-md-8">
		<div class="tab-content" style="margin:0px;">
			<div id="home" class="tab-pane fade in active r3_counter_box">

				
				<!--form class="form-horizontal"-->
				<div class="form-horizontal">
				

				<div class="form-group">
					<div class="col-sm-2  container-fluid"></div>
					<div class="col-sm-8 container-fluid" align="center">
						@if($viewing->pic!='')
						<img src={{ url('/') }}/{{$viewing->pic}} class="img-thumbnail" alt="Cinque Terre" width="304" height="236" id="profile_pic">

						@else
						<img src="{{ url('/') }}/uploads/profile_pics/emp.png" class="img-thumbnail" alt="Cinque Terre" width="304" height="236" id="profile_pic">
						@endif



					</div>
					<div class="col-sm-2  container-fluid">
						<p class="help-block">

							
						</p>
					</div>
				</div>

				</div>
				<div class="form-horizontal">
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-8">
						<div class="input-group" id="input_email">							
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
							</span>


							<input type="email" disabled class="form-control1" id="focusedinput" placeholder="" value="{{$viewing->email}}">

						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">

							<!--button style="padding-bottom:0px;" disabled id="changeEmail" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button-->
						</p>
					</div>
				</div>

				</div>

				<div class="form-horizontal">
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-8">
						<div class="input-group" id="input_name">							
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
							</span>

							
							<input type="text" name="name" disabled class="form-control1" id="focusedinput" placeholder="" value="{{$viewing->name}}">

						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">

							
						</p>
					</div>
				</div>

			</div>


				<div class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label">TP No</label>
					<div class="col-sm-8">
						<div class="input-group" id="input_tpno">							
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-phone" aria-hidden="true" ></span>
								+94
							</span>
							<input  type="text" disabled class="form-control1" placeholder="" value="{!! str_replace('+94', '', $viewing->tp) !!}" >
						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">

						</p>
					</div>
				</div>
				</div>

				@if(! empty($doctor) && $doctor->phone!='' )

				<div class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label">Working No</label>
					<div class="col-sm-8">
						<div class="input-group" id="input_tpnoWorking">							
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-phone" aria-hidden="true" ></span>
								+94
							</span>
							
							<input  type="text" name="tpnoWorking" disabled class="form-control1" placeholder="" value="{!! str_replace('+94', '', $doctor->phone) !!}" >
						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">
						</p>
					</div>
				</div>
				</div>

				@endif


				@if( $user->level>=10 )

				<div class="form-horizontal">
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label">NIC</label>
					<div class="col-sm-8">
						<div class="input-group" id="input_nic">							
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
							</span>

							
							<input type="text" name="nic" disabled class="form-control1" id="focusedinput" placeholder="" value="{{$viewing->nic}}">

						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">

							
						</p>
					</div>
				</div>

				</div>
				@endif

				@if(! empty($doctor) )
					<div class="form-horizontal">
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Specialization</label>
							<div class="col-sm-8">
								<div class="input-group">							
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
									</span>

							
									<input type="text" disabled class="form-control1" id="focusedinput" placeholder="" value="{{$doctor->specialization}}">

								</div>
							</div>
							<div class="col-sm-2">
						
							</div>
						</div>
					</div>
					<div class="form-horizontal">
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Professional qualtiys</label>
							<div class="col-sm-8">
								<div class="input-group">							
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
									</span>

							
									<input type="text" disabled class="form-control1" id="focusedinput" placeholder="" value="{{$doctor->profqual}}">

								</div>
							</div>
							<div class="col-sm-2">
						
							</div>
						</div>
					</div>

						<div class="form-horizontal">
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Educational qualtiys</label>
							<div class="col-sm-8">
								<div class="input-group">							
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
									</span>

							
									<input type="text" disabled class="form-control1" id="focusedinput" placeholder="" value="{{$doctor->eduqual}}">

								</div>
							</div>
							<div class="col-sm-2">
						
							</div>
						</div>
					</div>
						<div class="form-horizontal">
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Current Hospital</label>
							<div class="col-sm-8">
								<div class="input-group">							
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
									</span>

							
									<input type="text" disabled class="form-control1" id="focusedinput" placeholder="" value="{{$doctor->hospital}}">

								</div>
							</div>
							<div class="col-sm-2">
						
							</div>
						</div>
					</div>

				@endif

			</div>
			<div id="menu1" class="tab-pane fade r3_counter_box">
				<h3>Menu 1</h3>
				<p>Some content in menu 2.</p>
			</div>
			<div id="menu2" class="tab-pane fade r3_counter_box">
				<h3>Menu 2</h3>
				<p>Some content in menu 2.</p>
			</div>
		</div>

	</div>


</div>

<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content" style="color:black !important;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Confirm the Changes</h4>
			</div>
			<div class="modal-body">
				<p id="confirm_inpit_p">Retype</p>

				{!! Form::open(['role'=>'form','id' => 'fromModle']) !!}
				<!-- form name -->
				<input type="hidden" name="formname" value="reset"/>


				<div class="form-group  has-warning has-feedback">

					<label for="email"></label>
					<br>

					<div class="input-group">

						<input type="text" class="form-control1" id="confirm_input" id="inputWarning2" aria-describedby="inputWarning2Status">

					</div>
				</div>
				<button type="button" class="btn btn-primary btn-lg btn-block" id="confirm_input_send" value="">Confirm</button>

				{!! Form::close() !!}
			</div>
			<div class="modal-footer">
				<button type="button" id="modclose" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>

@stop
@section('footer')
@stop