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

		}
	</style>
	
</head>
<body>
	<?php
	include 'template/body.php';
	?>
	<div class="container-fluid" align="center">
		<div class="row">

			<div class="col-md-3">
				<div class="container" style="max-width:80%;height:auto;">
					<img src="http://www.keenthemes.com/preview/metronic/theme/assets/pages/media/profile/profile_user.jpg" class="img-thumbnail" alt="Cinque Terre" width="304" height="236">
				</div>
				<div class="container-fluid">
					<h3>User Contribution</h3>
					<div class="container-fluid" style="background-color: transparent;">

						<ul class="list-group" style="background-color: transparent;border: none;">
							<li style="background:rgba(0,0,0,0.5);color:white;border: none;" class="list-group-item"><span style="background:rgba(0,0,0,0.5);color:white;" class="badge">12</span> Doctors Added</li>
							<li style="background:rgba(0,0,0,0.5);color:white;border: none;" class="list-group-item"><span style="background:rgba(0,0,0,0.5);color:white;" class="badge">5</span> Forum activites</li> 
							<li style="background:rgba(0,0,0,0.5);color:white;border: none;" class="list-group-item"><span style="background:rgba(0,0,0,0.5);color:white;" class="badge">3</span> Tickets</li>
						</ul>

					</ul>
				</div>
			</div>

		</div>
		<div class="col-md-9">
		<div class="well" style="background:rgba(0,0,0,0.5);color:white;border: none;">
			<form role="form" style="margin-left:10%;margin-right:10%;color:white;">

			<div class="form-group">
					<label for="email" style="float:left;">Username:</label>
					<input type="text" class="form-control" id="email" value="Sleepy" style="background:rgba(0,0,0,0.7);background-color: transparent;color:white;">
				</div>
				<div class="form-group">
					<label for="email" style="float:left;">NIC:</label>
					<input type="text" class="form-control" id="email" value="123456789V" style="background:rgba(0,0,0,0.7);background-color: transparent;color:white;">
				</div>
				<div class="form-group">
					<label for="email" style="float:left;">Email address:</label>
					<input type="email" class="form-control" id="email" value="alexvista1234@gmail.com" style="background:rgba(0,0,0,0.7);background-color: transparent;color:white;">
				</div>
				<div class="form-group">
					<label for="pwd" style="float:left;">Password:</label>
					<input type="password" class="form-control" id="pwd" value="124" style="background:rgba(0,0,0,0.7);background-color: transparent;color:white;">
				</div>

				<div class="form-group">
					<label for="pwd" style="float:left;">Telephone no:</label>
					<input type="number" class="form-control" id="pwd" value="0774117218" style="background:rgba(0,0,0,0.7);background-color: transparent;color:white;">
				</div>
				
				<button type="submit" class="btn btn-default">Save</button>
			</form>
	</div>
		</div>
	</div>

</div>
</body>
</html>