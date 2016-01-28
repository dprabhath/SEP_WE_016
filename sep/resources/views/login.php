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
			
    		$("#myBtn1").click(function(){
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
	//include 'template/body.php';
	?>
    	

	<div class="container-fluid">
		<div class="row" style="padding-top:10%;">
			<div class="col-md-4">
			</div>
			<div class="col-md-4" >
				<div class="well" id="login_well" style="background:rgba(0,0,0,0.5);color:white;border: none;">
			
				<form role="form">
					<div class="form-group">
						<div class="input-group">
                        	<span class="input-group-addon transparent-icon" style="background:rgba(0,0,0,0.5);color:white;background-color: transparent;"><span  class="glyphicon glyphicon-envelope"></span></span>
							<input type="text" style="background:rgba(0,0,0,0.5);color:white;background-color: transparent;" class="form-control1 transparent" id="email" placeholder="Email address/Phone Number">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
                                 <span class="input-group-addon transparent-icon" style="background:rgba(0,0,0,0.5);color:white;background-color: transparent;"><span class="glyphicon glyphicon-lock"></span></span>
						<input type="password " class="form-control1 transparent" id="pwd" placeholder="Password" style="background:rgba(0,0,0,0.5);color:white;background-color: transparent;">
						</div>

					</div>
					<div class="container-fluid" align="center">
					<label class="col-sm-6">
							
							
							<button type="button" class="btn btn-link" id="myBtn1" style="color:white;">
								Lost Your Password?
							</button>
							
							
					</label>
					<div class="form-group col-sm-6">
					<button  type="submit" class="btn btn-primary btn-lg btn-block" >
						Login
					</button>
					</div>
					</div>
					<div class="form-group col-sm-12" align="center">
							<button type="button" class="btn btn-link" id="myBtn" style="color:white;margin-bottom:0px;padding-bottom:0px;">
								New ? Register here
							</button>
					</div>
					
					<div class="container-fluid" align="center">
							<h2></h2>
					</div>

					<div class="form-group">
						<div class="input-group">
                                 <span class="input-group-addon warning_1 btn-success" style="color:white;">g+</span>
						<button type="button" class="form-control1 btn-success warning_1" id="pwd" style="color:white;" >Google +</button>
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
                                 <span class="input-group-addon btn-warning warning_11">f</span>
						<button type="button" class="form-control1 btn-warning warning_11" id="pwd" style="color:white;padding-right:100px;">FaceBook</button>
						</div>
					</div>

					
					
					
					
				</form>
				
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
          <form role="form">
  <div class="form-group  has-warning has-feedback">
  	
    <label for="email">Email address/Phone Number:</label>
    <br>
    
     <div class="input-group">
     
    <input type="email" class="form-control1" id="email" id="inputWarning2" aria-describedby="inputWarning2Status">
   
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