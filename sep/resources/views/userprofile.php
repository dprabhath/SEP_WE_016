<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	include 'template/head.php';
	?>
	

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



	</style>
</head>

<body >
	<div id="wrapper" class="container-fluid r3_counter_box"  align="center">
		
		<div id="header" align="left">
			<?php
			include 'template/body.php';
			?>
		</div><!-- #header -->
		
		<div id="content" align="left">
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
							
							<h3>Mr.Sampath</h3>
							<form class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-2 control-label">UserName</label>
									<div class="col-sm-8">
										<div class="input-group">							
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
											</span>
											<input type="text" disabled="" class="form-control1" placeholder="" value="Sampath widushan" >
										</div>
									</div>
									<div class="col-sm-2">
										<p class="help-block">
											
											<button style="padding-bottom:0px;" type="button" class="btn btn-link"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
										</p>
									</div>
								</div>

								<div class="form-group has-success has-feedback">
									<label for="focusedinput" class="col-sm-2 col-xs-2 control-label">Password</label>
									<div class="col-sm-8 ">
										<div class="input-group">							
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
											</span>
											<input type="password" disabled="" class="form-control1" id="focusedinput" placeholder="" value="Sampath widushan">
											<span class="glyphicon glyphicon-ok form-control-feedback"></span>
										</div>
									</div>
									<div class="col-sm-2 ">
										<p class="help-block">
											
											<button style="padding-bottom:0px;" type="button" class="btn btn-link"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
										</p>
									</div>



								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Email</label>
									<div class="col-sm-8">
										<div class="input-group input-icon right spinner">							
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
											</span>
				
											<i class="fa fa-fw fa-spin fa-spinner"></i>
											<input type="email" disabled="" class="form-control1" id="focusedinput" placeholder="" value="Sampathwidushan@gmail.com">
											
										</div>
									</div>
									<div class="col-sm-2">
										<p class="help-block">
											
											<button style="padding-bottom:0px;" type="button" class="btn btn-link"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
										</p>
									</div>
								</div>

							</form>
							
							
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
			
		</div><!-- #content -->
		
		<div id="footer" align="left">
			<?php
			include 'template/footer.php';
			?>
		</div><!-- #footer -->
		
	</div><!-- #wrapper -->
</body>

</html>