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
		$(document).ready(function(){


			$('#input_email').dbclick(function(){
				$(this).removeAttr( "disabled" );


			});


/*---------------profile picuter change jquery functions -------------------*/
			$('#changePic').click(function(){
				$('#picfile').click();
				
			});
			$('#picfile').change(function (){
       			var fileName = $(this).val();
      			//alert(fileName);
      			if(fileName!=''){
      				$("#picture").submit();
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
										<img src={{$user->pic}} class="img-thumbnail" alt="Cinque Terre" width="304" height="236" id="profile_pic">

									@else
										<img src="uploads/profile_pics/emp.png" class="img-thumbnail" alt="Cinque Terre" width="304" height="236" id="profile_pic">
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
										<div class="input-group input-icon right spinner">							
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
											</span>
				
											
											<input id="input_email" type="email" disabled class="form-control1" id="focusedinput" placeholder="" value={{$user->email}}>
											
										</div>
									</div>
									<div class="col-sm-2">
										<p class="help-block">
											
											<button style="padding-bottom:0px;" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
										</p>
									</div>
								</div>

							{!! Form::close() !!}

							{!! Form::open(['id' => 'passwordForm','class'=>'form-horizontal']) !!}
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 col-xs-2 control-label">Password</label>
									<div class="col-sm-8 ">
										<div class="input-group">							
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
											</span>
											<input id="input_password" type="password" disabled class="form-control1" id="focusedinput" placeholder="" value="Sampath widushan">
											
										</div>
									</div>
									<div class="col-sm-2 ">
										<p class="help-block">
											
											<button style="padding-bottom:0px;" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
										</p>
									</div>


							</div>

							
								
								{!! Form::close() !!}

							{!! Form::open(['id' => 'tpnoForm','class'=>'form-horizontal']) !!}
								<div class="form-group">
									<label class="col-sm-2 control-label">TP No</label>
									<div class="col-sm-8">
										<div class="input-group">							
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
											</span>
											<input id="input_tpno" type="text" disabled class="form-control1" placeholder="" value={{$user->tp}} >
										</div>
									</div>
									<div class="col-sm-2">
										<p class="help-block">
											
											<button style="padding-bottom:0px;" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
										</p>
									</div>
								</div>
							{!! Form::close() !!}
							
								

							
							
								{!! Form::open(['id' => 'nicForm','class'=>'form-horizontal']) !!}
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">NIC</label>
									<div class="col-sm-8">
										<div class="input-group input-icon right spinner">							
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
											</span>
				
											
											<input type="text" id="input_nic"  disabled class="form-control1" id="focusedinput" placeholder="" value={{$user->nic}}>
											
										</div>
									</div>
									<div class="col-sm-2">
										<p class="help-block">
											
											<button style="padding-bottom:0px;" type="button" class="btn btn-link"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
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
			<div id="wait">
		
	</div>
			
@stop
@section('footer')
@stop