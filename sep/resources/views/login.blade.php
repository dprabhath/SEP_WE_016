<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="resources/common/css/bootstrap.css">
	<link rel="stylesheet" href="resources/common/css/clndr.css">
	<link rel="stylesheet" href="resources/common/css/custom.css">
	<link rel="stylesheet" href="resources/common/css/font-awesome.css">
	<link rel="stylesheet" href="resources/common/css/jqvmap.css">
	<link rel="stylesheet" href="resources/common/css/lines.css">
	<link rel="stylesheet" href="resources/common/css/style.css">
	<link rel="stylesheet" href="resources/common/css/lobibox.css">

	<!-- jQuery library -->


	<!-- Latest compiled JavaScript -->


	<script src="resources/common/js/jquery.min.js"></script>
	<script src="resources/common/js/bootstrap.min.js"></script>
	<script src="resources/common/js/Chart.js"></script>
	<script src="resources/common/js/clndr.js"></script>
	<script src="resources/common/js/custom.js"></script>
	<script src="resources/common/js/d3.v3.js"></script>

	<script src="resources/common/js/jquery.vmap.js"></script>
	<script src="resources/common/js/jquery.vmap.sampledata.js"></script>
	<script src="resources/common/js/metisMenu.min.js"></script>
	<script src="resources/common/js/moment-2.2.1.js"></script>
	<script src="resources/common/js/rickshaw.js"></script>
	<script src="resources/common/js/site.js"></script>
	<script src="resources/common/js/underscore-min.js"></script>
	<script src="resources/common/js/lobibox.js"></script>
	<link href="//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900" rel='stylesheet' type='text/css'>
	<style type="text/css">


		html,
		body {
			margin:0;
			padding:0;
			height:100%;

			background: rgba(212,228,239,1);
			background: -moz-linear-gradient(left, rgba(212,228,239,1) 0%, rgba(134,174,204,1) 100%);
			background: -webkit-gradient(left top, right top, color-stop(0%, rgba(212,228,239,1)), color-stop(100%, rgba(134,174,204,1)));
			background: -webkit-linear-gradient(left, rgba(212,228,239,1) 0%, rgba(134,174,204,1) 100%);
			background: -o-linear-gradient(left, rgba(212,228,239,1) 0%, rgba(134,174,204,1) 100%);
			background: -ms-linear-gradient(left, rgba(212,228,239,1) 0%, rgba(134,174,204,1) 100%);
			background: linear-gradient(to right, rgba(212,228,239,1) 0%, rgba(134,174,204,1) 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d4e4ef', endColorstr='#86aecc', GradientType=1 );

		}

		.navbar-brand {
			padding: 0px !important;
			/* firefox bug fix */
		}
		.navbar-brand>img {
			height: 100%;
			padding: 15px; /* firefox bug fix */
			width: auto;

		}

		@media (max-width: 768px) {
			/* For mobile phones: */

		}
		@media (min-width: 768px) {

			.navbar-nav > li > a {
				padding-top:25px !important; 
				padding-bottom:0 !important; 
				height: 70px;
			}
			.navbar {min-height:70px !important;}

			.navbar-brand {
				padding: 0px !important;
				height: 65px; /* firefox bug fix */
			}

		}
		.custom_profile_pic {
			position: relative;
			top: -5px;
			float: left;
			left: -5px;
			width:32px;
			max-width:32px;
		}
		#wrapper {
			width:1000px;
			min-height:100%;
			position:relative;
			background-color: rgba(255,255,255,0.5) !important;
			padding:0px;
		}
		#header {
			background:#ededed;
			padding:0px;
		}
		#content {
			padding-bottom:100px !important;
			padding: 15px; /* Height of the footer element */
		}
		#footer {
			background:black;
			width:100%;
			height:50px;
			position:absolute;
			margin-top: 100px;
			bottom:0;
			left:0;
			color:white !important;
			background-color: rgba(0,0,0,0.7) !important;


		}

		@media (max-width: 768px) {
			/* For mobile phones: */
			#wrapper {
				width:100%;
				min-height:100%;
				position:relative;
			}
		}
	</style>
	<!--nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;" style="border-radius:0px;background:rgba(0,0,0,0.7);border:none;"-->

	
	<style type="text/css">

		body{
			background-image: url("resources/common/picutres/background.jpg");
			color:white;
			background-color: transparent;


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
	<script>
	
$( window ).load(function() {

	
  @if(!empty($fail) && $fail == 1)
				
				Lobibox.notify("error", {
					title: 'Check again',
					msg: 'Check your email and password',
					sound: '../resources/common/sounds/sound5'
				});
	@endif
});
		
		$(document).ready(function(){

			
			

			function isEmail(email) {
				var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				return regex.test(email);
			}
			function isPhone(phone){
				var regex = /^[0-9]{10}$/;
				return regex.test(phone);
			}
			$("#myBtn1").click(function(){
				$("#myModal").modal();
			});

			$("#sendReset").click(function(){
				//alert("click Detected");
				var email = $('[name=email]').val();
				
				if(isEmail(email)){
					$( "#passrecover" ).submit();
				}else if(isPhone(email)){
					$( "#passrecover" ).submit();
				}else{
					Lobibox.notify("warning", {
						title: 'Not Found',
						msg: 'Check your email/phone number',
						sound: '../resources/common/sounds/sound5'
					});
				}
				
				//$.post('', $('#passrecover').serialize());
			});

			$("#login_form").submit(function(e){

				var email = $('[name=email_login]').val();
				var password = $('[name=password_login]').val();
				if(isEmail(email) && password!=""){

				}else{
					Lobibox.notify("warning", {
						title: 'Check again',
						msg: 'Check your email/phone number',
						sound: '../resources/common/sounds/sound5'
					});
					e.preventDefault();
					
				}

			});

			$("#passrecover").submit(function(e)
			{
				$('#wait').show();

				var postData = $(this).serializeArray();
				var formURL = $(this).attr("action");
				$.ajax(
				{
					url : formURL,
					type: "POST",
					data : postData,
					success:function(data, textStatus, jqXHR) 
					{
            		//data: return data from server
            		if(data=="ok"){
            			Lobibox.notify("success", {
            				title: 'Sent',
            				msg: 'Check your inbox for your new password',
            				sound: '../resources/common/sounds/sound2'
            			});
            			$('#modclose').click();
            		}else if(data=="notfound"){
            			Lobibox.notify("warning", {
            				title: 'Not Found',
            				msg: 'Check your email/phone number',
            				sound: '../resources/common/sounds/sound5'
            			});
            		}else{
            			Lobibox.notify("error", {
            				title: 'Erro',
            				msg: 'An erro occurd contact server administrator',
            				sound: '../resources/common/sounds/sound4'
            			}); 
            		}
            		$('#wait').hide();


            	},
            	error: function(jqXHR, textStatus, errorThrown) 
            	{
            		Lobibox.notify("error", {
            			title: 'Erro',
            			msg: 'An erro occurd',
            			sound: '../resources/common/sounds/sound4'
            		});
            		$('#wait').hide(); 
            	}
            });
   				e.preventDefault(); //STOP default action
    			//e.unbind(); //unbind. to stop multiple form submit.
    		});


});

</script>
</head>

<body class="bodybg">

	

	<div class="container-fluid">
		<div class="row" style="padding-top:10%;">
			<div class="col-md-4">
			</div>
			<div class="col-md-4" >
				<div class="well" id="login_well" style="background:rgba(0,0,0,0.5);color:white;border: none;">

					{!! Form::open(['role'=>'form','id' => 'login_form','style' => 'padding-top:20px;']) !!}
					<input type="hidden" name="formname" value="loginFrom"/>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon transparent-icon" style="background:rgba(0,0,0,0.5);color:white;background-color: transparent;"><span  class="glyphicon glyphicon-envelope"></span></span>
							<input type="text" style="background:rgba(0,0,0,0.5);color:white;background-color: transparent;" name="email_login" class="form-control1 transparent" id="email" placeholder="Email address/Phone Number">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon transparent-icon" style="background:rgba(0,0,0,0.5);color:white;background-color: transparent;"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" name="password_login" class="form-control1 transparent" id="pwd" placeholder="Password" style="background:rgba(0,0,0,0.5);color:white;background-color: transparent;">
						</div>

					</div>
					<div class="row" >
						<div class="col-sm-2">
						</div>
						<div class="col-sm-8" align="center">
							<button  type="submit" class="btn btn-primary btn-lg btn-block" >
								Login
							</button>
						</div>
						<div class="col-sm-2">
						</div>
					</div>




					<div class="row" style="padding-top:20px;">
						<div class="col-md-2 col-sm-2 col-xs-2">
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2" align="center" style="padding-right:0px;margin-right:0px;">
							<i class="icon_4">G</i>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3" align="center" style="padding-left:0px;margin-left:0px;">
							<i class="icon_4 icon_5">F</i>
						</div>




					</div>

					<div class="row" style="padding-top:40px;">
						<div class="col-sm-6" align="center" style="padding-left:0px;margin-left:0px;">


							<button type="button" class="btn btn-link" id="myBtn1" style="color:white;">
								Lost Your Password?
							</button>


						</div>

						<div class="form-group col-sm-6" align="center">
							<button type="button" class="btn btn-link" id="new_reg" style="color:white;margin-bottom:0px;padding-bottom:0px;">
								<a href="register" style="color:white;">New ? Register here</a>
							</button>
						</div>
					</div>





					{!! Form::close() !!}

				</div>

			</div>
			<div class="col-md-4">
			</div>
		</div>
	</div>
</body>


<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content" style="color:black !important;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Reset Your Account Password</h4>
			</div>
			<div class="modal-body">
				<p>Enter your Email Here we will email you an link to reset the password.</p>

				{!! Form::open(['role'=>'form','id' => 'passrecover']) !!}
				<!-- form name -->
				<input type="hidden" name="formname" value="reset"/>


				<div class="form-group  has-warning has-feedback">

					<label for="email">Email address/Phone Number:</label>
					<br>

					<div class="input-group">

						<input type="text" class="form-control1" name="email" id="email" id="inputWarning2" aria-describedby="inputWarning2Status">

					</div>
				</div>
				<button type="button" class="btn btn-primary btn-lg btn-block" id="sendReset">Send Rest Link</button>

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

</html>