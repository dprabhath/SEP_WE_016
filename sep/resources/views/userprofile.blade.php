@extends('template/template_user')

@section('head')

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

		display:    none;
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
</style>
<script type="text/javascript">
	/*************************REGEX Checks*******************************/

	function isEmail(email) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}
	function isPhone(phone){
		var regex = /^[0-9]{10}$/;
		return regex.test(phone);
	}
	function isNIC(nic){
		var regex = /^[0-9]{9}[v]{1}$/;
		return regex.test(nic);
	}
	/**************************jquery post*******************************/
	function postdata(name){
		//alert(name);

		$('form#'+name).submit(function(e){
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
e.preventDefault();
e.unbind();
return false;
});
$('#'+name).submit();
}

$(document).ready(function(){



/*******************************save clicks handle****************//////////////

$('#changePassword').click(function(){

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

$('#changeNic').click(function(){

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
/****************After modle confirm click***************************************/
$('#confirm_input_send').click(function(){
	if($('#confirm_input').val()==$('[name="nic"]').val() && $('#confirm_input_send').attr("hi")=="nic"){


		postdata("nicForm");

	}else if($('#confirm_input').val()==$('[name="password"]').val() && $('#confirm_input_send').attr("hi")=="pass"){
		postdata("passwordForm");
	}else{
		Lobibox.notify("error", {
			title: 'Erro',
			msg: "your input value is mismatch from the previous",
			sound: '../resources/common/sounds/sound4'
		});
	}
});
/***********************inputs disbalitiy unlock *****************/
$('#input_email').dblclick(function(){
	$('#input_email input').removeAttr( "disabled" );
	$('#input_email input').focus();

});
$('#input_tpno').dblclick(function(){
	$('#input_tpno input').removeAttr( "disabled" );
	$('#input_tpno input').focus();

});
$('#input_password').dblclick(function(){
	$('#input_password input').removeAttr( "disabled" );
	$('#changePassword').removeAttr("disabled");
	$('#input_password input').focus();

});
$('#input_nic').dblclick(function(){
	$('#input_nic input').removeAttr( "disabled" );
	$('#changeNic').removeAttr("disabled");
	$('#input_nic input').focus();

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
	e.unbind();
	return false;
});

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
			<a data-toggle="tab" href="#menu1" class="list-group-item"><span class="badge badge-warning">4.5/5</span>Rating </a> 
			<a data-toggle="tab" href="#menu1" class="list-group-item"><span class="badge badge-warning">14</span> Posts created </a>
			<a data-toggle="tab" href="#menu1" class="list-group-item"><span class="badge badge-warning">100</span>Contributions </a> 
			<a data-toggle="tab" href="#menu1" class="list-group-item"><span class="badge badge-warning">14</span> Messages </a> 
			<a data-toggle="tab" href="#menu1" class="list-group-item"><span class="badge badge-danger">30</span>Notifications </a> 
		</div>
	</div>
	<div class="col-md-8">
		<div class="tab-content" style="margin:0px;">
			<div id="home" class="tab-pane fade in active r3_counter_box">

				<h3>{{$user->name}}</h3>
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


							<input type="email" disabled class="form-control1" id="focusedinput" placeholder="" value={{$user->email}}>

						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">

							<button style="padding-bottom:0px;" disabled id="changeEmail" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
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
							<input  type="password" name="password" disabled class="form-control1" id="focusedinput" placeholder="" value={{$user->password}}>

						</div>
					</div>
					<div class="col-sm-2 ">
						<p class="help-block">

							<button style="padding-bottom:0px;" disabled id="changePassword" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
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
							</span>
							<input  type="text" disabled class="form-control1" placeholder="" value={{$user->tp}} >
						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">

							<button style="padding-bottom:0px;" disabled id="changeTpno" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
						</p>
					</div>
				</div>
				{!! Form::close() !!}





				{!! Form::open(['id' => 'nicForm','class'=>'form-horizontal']) !!}
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label">NIC</label>
					<div class="col-sm-8">
						<div class="input-group" id="input_nic">							
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
							</span>

							{!! Form::hidden('formname','nicForm') !!}
							<input type="text" name="nic" disabled class="form-control1" id="focusedinput" placeholder="" value={{$user->nic}}>

						</div>
					</div>
					<div class="col-sm-2">
						<p class="help-block">

							<button style="padding-bottom:0px;" disabled id="changeNic" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
						</p>
					</div>
				</div>

				{!! Form::close() !!}


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

				{!! Form::open(['role'=>'form']) !!}
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