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
	#wait{

		
		position:   fixed;
		z-index:    10000000;
		top:        0;
		left:       0;
		height:     100%;
		width:      100%;
		background: rgba( 255, 255, 255, .8 ) 
		url('resources/common/gif/ajax-loader.gif') 
		50% 50% 
		no-repeat;
	}

	.toggle.android { width: 100%;}
</style>
<script type="text/javascript">
	const token = "{{ csrf_token() }}";
	/*************************REGEX Checks*******************************/

	function isEmail(email) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}
	function isPhone(phone){
		var regex = /^[0-9]{9}$/;
		return regex.test(phone);
	}
	function isNIC(nic){
		var regex = /^[0-9]{9}[v]{1}$/;
		return regex.test(nic);
	}
	/**************************jquery post*******************************/
	function ajaxs(formData){
		$.ajax({
				url: window.location.pathname,
				type: 'POST',
				data: formData,
				async: false,
				success: function (data) {
					if(data['code']=="success"){
						Lobibox.notify("success", {
							title: 'success',
							msg: data['message'],
							sound: '../resources/common/sounds/sound2'
						});
						$('#modclose').click();
							//d = new Date();
							//$("#profile_pic").attr("src",data['filename']+"?"+d.getTime());
							
						}else if(data['code']=="warning"){
							Lobibox.notify("warning", {
								title: 'warning',
								msg: data['message'],
								sound: '../resources/common/sounds/sound5'
							});
						}else{
							Lobibox.notify("error", {
								title: 'Erro',
								msg: data['message'],
								sound: '../resources/common/sounds/sound4'
							}); 
						}
						$('#wait').hide();
					},
					error: function(data){
						Lobibox.notify("error", {
							title: 'Erro',
							msg: 'An erro occurd',
							sound: '../resources/common/sounds/sound4'
						}); 
						$('#wait').hide();
					},
					cache: false,
					contentType: false,
					processData: false
				});
	}
	/*
	function postdata(name){
		//alert(name);

		$('form#'+name).submit(function(e){
			$('#wait').show();
			var formData = new FormData($(this)[0]);
			ajaxs(formData);
			
e.preventDefault();
//e.unbind();
return false;
});
$('#'+name).submit();
}
*/
$(document).ready(function(){

$('#wait').hide();

/*******************************save clicks handle****************//////////////

$('#changePassword').click(function(){
	$('form#passwordForm').submit();
});

$('#changeNic').click(function(){
	$('form#nicForm').submit();
});
$('#changeName').click(function(){
		$('form#nameForm').submit();
});
$('#changeTpnoWorking').click(function(){
	$('form#tpnoFormDoctor').submit();
});
/****************After modle confirm click***************************************/
$('#confirm_input_send').click(function(){
	if($('#confirm_input').val()==$('[name="nic"]').val() && $('#confirm_input_send').attr("hi")=="nic"){
		$('#wait').show();
		var formData = new FormData($('form#nicForm')[0]);
		ajaxs(formData);

	}else if($('#confirm_input').val()==$('[name="password"]').val() && $('#confirm_input_send').attr("hi")=="pass"){
		//postdata("passwordForm");
		$('#wait').show();
		var formData = new FormData($('form#passwordForm')[0]);
		ajaxs(formData);
	}else{
		Lobibox.notify("error", {
			title: 'Erro',
			msg: "your input value is mismatch from the previous",
			sound: '../resources/common/sounds/sound4'
		});
	}
});
/***********************inputs disbalitiy unlock *****************/
$('#input_email').click(function(){
	$('#input_email input').removeAttr( "disabled" );
	$('#input_email input').focus();

});
/*
$('#input_tpno').dblclick(function(){
	$('#input_tpno input').removeAttr( "disabled" );
	$('#changeTpno').removeAttr("disabled");
	$('#input_tpno input').focus();

});
*/
$('#input_password').click(function(){
	$('#input_password input').removeAttr( "disabled" );
	$('#changePassword').removeAttr("disabled");
	$('#input_password input').focus();

});
$('#input_nic').click(function(){
	$('#input_nic input').removeAttr( "disabled" );
	$('#changeNic').removeAttr("disabled");
	$('#input_nic input').focus();

});
$('#input_name').click(function(){
	$('#input_name input').removeAttr( "disabled" );
	$('#changeName').removeAttr("disabled");
	$('#input_name input').focus();

});
$('#input_tpnoWorking').click(function(){
	$('#input_tpnoWorking input').removeAttr( "disabled" );
	$('#changeTpnoWorking').removeAttr("disabled");
	$('#input_tpnoWorking input').focus();
});

/*---------------profile picuter change jquery functions -------------------*/
$('#changePic').click(function(){
	$('#picfile').click();

});
$('#picfile').change(function (){
	var fileName = $(this).val();
      			//alert(fileName);
      			if(fileName!=''){
      				$("#pictureForm").submit();
      			}
      			
      			
      			/** upload to the server **/

      		});

$("form#pictureForm").submit(function(e){
	$('#wait').show();
	var formData = new FormData($(this)[0]);

	$.ajax({
		url: window.location.pathname,
		type: 'POST',
		data: formData,
		async: false,
		success: function (data) {
			if(data['code']=="success"){
				Lobibox.notify("success", {
					title: 'success',
					msg: data['message'],
					sound: '../resources/common/sounds/sound2'
				});
				d = new Date();
				$("#profile_pic").attr("src",data['filename']+"?"+d.getTime());

			}else if(data['code']=="warning"){
				Lobibox.notify("warning", {
					title: 'warning',
					msg: data['message'],
					sound: '../resources/common/sounds/sound5'
				});
			}else{
				Lobibox.notify("error", {
					title: 'Erro',
					msg: data['message'],
					sound: '../resources/common/sounds/sound4'
				}); 
			}
			
			$('#wait').hide();
		},
		error: function(data){
			Lobibox.notify("error", {
				title: 'Erro',
				msg: 'An erro occurd',
				sound: '../resources/common/sounds/sound4'
			}); 
			$('#wait').hide();
		},
		cache: false,
		contentType: false,
		processData: false
	});
	e.preventDefault();
	//e.unbind();
	return false;
});

$('form#nameForm').submit(function(e){

	e.preventDefault();
	if($('[name="name"]').val()!=''){
		$('#wait').show();
		var formData = new FormData($(this)[0]);
		ajaxs(formData);
	}else{
		Lobibox.notify("warning", {
			title: 'warning',
			msg: "Check the Name",
			sound: '../resources/common/sounds/sound5'
		});
	}
	

});

$('form#nicForm').submit(function(e){

	e.preventDefault();
	if(isNIC($('[name="nic"]').val())){
		$('#confirm_inpit_p').html("Retype your NIC");
		$('#confirm_input').removeAttr( "type" );
		$('#confirm_input').val("");
		$('#confirm_input').attr( "type", "text" );
		$('#confirm_input_send').attr("hi","nic");
		$('#myModal').modal();
	}else{
		Lobibox.notify("warning", {
			title: 'warning',
			msg: "Check the NIC!",
			sound: '../resources/common/sounds/sound5'
		});
	}
	

});

$('form#passwordForm').submit(function(e){

	e.preventDefault();
	if($('[name="password"]').val()!=''){


		$('#confirm_inpit_p').html("Retype your new Password");
		$('#confirm_input').removeAttr( "type" );
		$('#confirm_input_send').attr("hi","pass");
		$('#confirm_input').val("");
		$('#confirm_input').attr( "type", "password" );
		$('#myModal').modal();
	}else{
		Lobibox.notify("warning", {
			title: 'warning',
			msg: "You cannot have blank passowrds",
			sound: '../resources/common/sounds/sound5'
		});
	}
	

});

$('form#tpnoFormDoctor').submit(function(e){

	e.preventDefault();
	if(isPhone($('[name="tpnoWorking"]').val())){
		$('#wait').show();
		var formData = new FormData($(this)[0]);
		ajaxs(formData);
	}else{
		Lobibox.notify("warning", {
			title: 'warning',
			msg: "Check the Phone Number",
			sound: '../resources/common/sounds/sound5'
		});
	}
	

});
$('form#fromModle').submit(function(e){
	e.preventDefault();
	$('#confirm_input_send').click();

});

	@if(! empty($doctor) )
	$('#toggle-two').change(function() {
      //alert($(this).prop('checked'));
      
      //jsend(d);
    });
    	$("#available").on('click', '.android', function () {
    		if($('#toggle-two').prop('checked')==true){
    			var d = {"_token": token ,"task": "available" ,"status": "false"};
    			jsend(d);
    		}else{
    			var d = {"_token": token ,"task": "available" ,"status": "true"};
    			jsend(d);
    		}
    	});

		@if( $doctor->available==0 )
    		$('#toggle-two').bootstrapToggle('off');
    	@else
    		$('#toggle-two').bootstrapToggle('on');
    	@endif
    @endif


	
});

function jsend(dataString){
  $('#wait').show();
   var datas;
   $.ajax({
    type:"POST",
    url : "{{ url('/') }}/profile",
    data:dataString,
    success : function(data){
        //document.getElementById("re").innerHTML=data['code']; 
        returnofjsend(data);
        
      },
      error: function(jqXHR, textStatus, errorThrown) 
      {
        $('#wait').hide();
        Lobibox.notify("error", {
          title: 'Erro',
          msg: 'An erro occurd',
          sound: '../resources/common/sounds/sound4'
        });
        
      }

    },"json");

   
 }

function returnofjsend(data){

	$('#wait').hide();
	if(data['code']=="error"){
		Lobibox.notify("error", {
          title: 'Erro',
          msg: 'Contatct Administrators',
          sound: '../resources/common/sounds/sound4'
        });
		return;
	}
	if(data['task']=="available"){

		if(data['status']=="true"){
			$('#toggle-two').bootstrapToggle('on');
		}else{
			$('#toggle-two').bootstrapToggle('off');
		}

		Lobibox.notify("success", {
      	title: 'success',
      	msg: 'Status Updated',
      	sound: '../resources/common/sounds/sound2'
    	});
  	}


}
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
				<a target="_blank" href="{{ url('/') }}/doctors/{{$doctor->id}}" class="list-group-item">Doctor Profile </a>

				<a target="_blank" href="{{ url('/') }}/profile/cancelslot" class="list-group-item"> Cancel Slots </a>

				<a target="_blank" href="{{ url('/') }}/profile/schedule" class="list-group-item"> Timeslots </a>

				<a class="list-group-item"><span class="badge badge-warning">{{$doctor->rating}}</span>Rating </a> 
				<a class="list-group-item" id='available'>
				
				<input type="checkbox" checked data-toggle="toggle" id="toggle-two" data-on="Available for Appointments" data-off="Not Available for Appointments" data-offstyle="danger" data-style="android" >
				
				 </a> 
			@endif
			
			<a target="_blank" href="{{ url('/') }}/view-ticket" class="list-group-item"><span class="badge badge-warning">{{ $ticketCount }}</span> Tickets Created </a>
			<a target="_blank" href="{{ url('/') }}/view-appointment" class="list-group-item"><span class="badge badge-warning">{{ $appointmentCount }}</span>Placed Appointments </a>
		</div>
	</div>
	<div class="col-md-8">
		<div class="tab-content" style="margin:0px;">
			<div id="home" class="tab-pane fade in active r3_counter_box">

				
				<!--form class="form-horizontal"-->
				{!! Form::open(['id' => 'pictureForm','class'=>'form-horizontal','files' => true]) !!}

				{!! Form::file('pic',['style'=>'visibility: hidden;display:none;','id'=>'picfile','accept'=>'image/*']) !!}
				{!! Form::hidden('formname','picture') !!}

				<div class="form-group">
					<div class="col-sm-2  container-fluid"></div>
					<div class="col-sm-8 container-fluid" align="center">
						@if($user->pic!='')
						<img src={{ url('/') }}/{{$user->pic}} class="img-thumbnail" alt="Cinque Terre" width="304" height="236" id="profile_pic">

						@else
						<img src="{{ url('/') }}/uploads/profile_pics/emp.png" class="img-thumbnail" alt="Cinque Terre" width="304" height="236" id="profile_pic">
						@endif



					</div>
					<div class="col-sm-2  container-fluid">
						<p class="help-block">

							<button style="padding-bottom:0px;" id="changePic" type="button" class="btn btn-link"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
						</p>
					</div>
				</div>

				{!! Form::close() !!}
				{!! Form::open(['id' => 'emailForm','class'=>'form-horizontal']) !!}
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-8">
						<div class="input-group" id="input_email">							
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
							</span>


							<input type="email" disabled class="form-control1" id="focusedinput" placeholder="" value="{{$user->email}}">

						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">

							<!--button style="padding-bottom:0px;" disabled id="changeEmail" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button-->
						</p>
					</div>
				</div>

				{!! Form::close() !!}

				{!! Form::open(['id' => 'passwordForm','class'=>'form-horizontal']) !!}
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 col-xs-2 control-label">Password</label>
					<div class="col-sm-8 ">
						<div class="input-group"  id="input_password">							
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
							</span>
							{!! Form::hidden('formname','passwordForm') !!}
							<input  type="password" name="password" disabled class="form-control1" id="focusedinput" placeholder="YourPassword" value="">

						</div>
					</div>
					<div class="col-sm-2 ">
						<p class="help-block">

							<button style="padding-bottom:0px;" disabled id="changePassword" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
						</p>
					</div>


				</div>



				{!! Form::close() !!}

				{!! Form::open(['id' => 'nameForm','class'=>'form-horizontal']) !!}
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label">Name</label>
					<div class="col-sm-8">
						<div class="input-group" id="input_name">							
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
							</span>

							{!! Form::hidden('formname','nameForm') !!}
							<input type="text" name="name" disabled class="form-control1" id="focusedinput" placeholder="" value="{{$user->name}}">

						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">

							<button style="padding-bottom:0px;" disabled id="changeName" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
						</p>
					</div>
				</div>

				{!! Form::close() !!}


				{!! Form::open(['id' => 'tpnoForm','class'=>'form-horizontal']) !!}
				<div class="form-group">
					<label class="col-sm-2 control-label">TP No</label>
					<div class="col-sm-8">
						<div class="input-group" id="input_tpno">							
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-phone" aria-hidden="true" ></span>
								+94
							</span>
							<input  type="text" disabled class="form-control1" placeholder="" value="{!! str_replace('+94', '', $user->tp) !!}" >
						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">

							<!--button style="padding-bottom:0px;" disabled id="changeTpno" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button-->
						</p>
					</div>
				</div>
				{!! Form::close() !!}

				@if(! empty($doctor) && $doctor->phone!='' )

				{!! Form::open(['id' => 'tpnoFormDoctor','class'=>'form-horizontal']) !!}
				<div class="form-group">
					<label class="col-sm-2 control-label">Working No</label>
					<div class="col-sm-8">
						<div class="input-group" id="input_tpnoWorking">							
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-phone" aria-hidden="true" ></span>
								+94
							</span>
							{!! Form::hidden('formname','tpnoFormDoctor') !!}
							<input  type="text" name="tpnoWorking" disabled class="form-control1" placeholder="" value="{!! str_replace('+94', '', $doctor->phone) !!}" >
						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">

							<button style="padding-bottom:0px;" disabled id="changeTpnoWorking" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
						</p>
					</div>
				</div>
				{!! Form::close() !!}

				@endif



				{!! Form::open(['id' => 'nicForm','class'=>'form-horizontal']) !!}
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label">NIC</label>
					<div class="col-sm-8">
						<div class="input-group" id="input_nic">							
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
							</span>

							{!! Form::hidden('formname','nicForm') !!}
							<input type="text" name="nic" disabled class="form-control1" id="focusedinput" placeholder="" value="{{$user->nic}}">

						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">

							<button style="padding-bottom:0px;" disabled id="changeNic" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
						</p>
					</div>
				</div>

				{!! Form::close() !!}

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
<div id="wait">

</div>

@stop
@section('footer')
@stop