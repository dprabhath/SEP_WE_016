<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	include 'template/head.php';
	?>
	
	<style type="text/css">

		body{
			background-image: url("resources/common/picutres/background.jpg");
			color:white;
			background-color: transparent;


		}
	</style>
	<script>
		$(document).ready(function(){
			
    		$("#myBtn").click(function(){
        	$("#myModal").modal();
    		});
    		
    		$("#sendReset").click(function(){
    			alert("click Detected");
    		});
		});
		
	</script>
</head>

 <body class="bodybg">
 <?php
	include 'template/body.php';
	?>
    	

	<div class="container-fluid">
		<div class="row" style="padding-top:10%;">
			<div class="col-md-3">
			</div>
			<div class="col-md-6" >
				<div class="well" id="login_well" style="background:rgba(0,0,0,0.5);color:white;border: none;">
			
				<form role="form">
					<div class="form-group">
						<div class="input-group">
                        	<span class="input-group-addon transparent-icon" style="background:rgba(0,0,0,0.5);color:white;background-color: transparent;"><span  class="glyphicon glyphicon-envelope"></span></span>
							<input type="text" style="background:rgba(0,0,0,0.5);color:white;background-color: transparent;" class="form-control transparent" id="email" placeholder="Email address/Phone Number">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
                                 <span class="input-group-addon transparent-icon" style="background:rgba(0,0,0,0.5);color:white;background-color: transparent;"><span class="glyphicon glyphicon-lock"></span></span>
						<input type="password " class="form-control transparent" id="pwd" placeholder="Password" style="background:rgba(0,0,0,0.5);color:white;background-color: transparent;">
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-lg btn-block" >
						Login
					</button>
					<div class="container-fluid" align="center">
						<label>
							<button type="button" class="btn btn-link" id="myBtn" style="color:white;">
								Lost Your Password?
							</button></label>
					</div>
					
					
					
				</form>
				
			</div>

			</div>
			<div class="col-md-3">
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
          <form role="form">
  <div class="form-group  has-warning has-feedback">
  	
    <label for="email">Email address/Phone Number:</label>
    <br>
    
     <div class="input-group">
     <span class="input-group-addon">@</span>
    <input type="email" class="form-control" id="email" id="inputWarning2" aria-describedby="inputWarning2Status">
    <span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
    </div>
  </div>
  <button type="button" class="btn btn-primary btn-lg btn-block" id="sendReset">Send Rest Link</button>
  
</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


</html>