<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	include 'template/head.php';
	?>
	
	<style type="text/css">
		.ellipsis {
			text-overflow: ellipsis;

			/* Required for text-overflow to do anything */
			white-space: nowrap;
			overflow: hidden;
			text-align: center;
			vertical-align: middle;

		}
		

	</style>
</head>

<body class="bodybg">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6"></div>
				<div class="col-sm-6 hidden-sm hidden-xs">
					<div class="input-group " style="width:100%;">
						<input type="text" class="form-control" placeholder="Username/Email/Telephone" >
						<span class="input-group-addon" style="background:rgba(0,0,0,0.7);background-color: transparent;"><span class="glyphicon glyphicon-search" style="color:black;"></span></span>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">
					<ul class="nav nav-pills nav-stacked">
						<li class="active"><a data-toggle="pill" href="#home">New User</a></li>
						<li><a data-toggle="pill" href="#menu1">View Registered Users</a></li>
					</ul>
				</div>
				<div class="col-md-9">
					<div class="tab-content" style="width:100%;min-width:100%;max-width:100%;">
						<div id="home" class="tab-pane fade in active" style="max-wdith:100%;">
							registration form
						</div>
						<div id="menu1" class="tab-pane fade" style="wdith:100%;">
							<table class="table table-hover" style="table-layout: fixed;width:100%;min-width:100%;" border="0">
								<thead>
									<tr style="width:100%;visibility: hidden;">
										<th style="width:5%;"></th>
										<th style="width:40%;"></th>
										<th style="width:30%;"></th>
										<th style="width:15%;"></th>
									</tr>
								</thead>
								<tbody class="ellipsis">
									<tr>
										<td colspan="4" style="width:100%;" class="hidden-lg hidden-md" >
											<div class="input-group" style="width:100%;">

												<input type="text" class="form-control" placeholder="Username/Email/Telephone" >
												<span class="input-group-addon" style="background:rgba(0,0,0,0.7);background-color: transparent;"><span class="glyphicon glyphicon-search" style="color:black;"></span></span>
											</div>
										</td>
									</tr>
									<tr >
										<td class="ellipsis"  valign="middle" >
											<input type="checkbox" value="ch1">
										</td>
										<td class="ellipsis"  valign="middle" > 
											aaaaaaaasssssss asda da das dad adad asdad asdasd asd asdasd asd
										</td> 
										<td class="ellipsis" valign="middle"  >
											<button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal">Change Password</button>
										</td>
										<td class="ellipsis" valign="middle"  >
											<button type="button" class="btn btn-primary btn-sm">Profile</button>
										</td>
									</tr>

									<tr>
										<td colspan="4">
											<div class="container-fluid" align="center">
												<nav>
													<ul class="pager">
														<li class="previous disabled">
															<a id="new1" href="#" style="font-weight: bold;background:rgba(0,0,0,0.5);"><span aria-hidden="true">&larr;</span> Newer</a>
														</li>
														<li class="next">
															<a id ="old1" href="#" style="font-weight: bold;background:rgba(0,0,0,0.5);">Older <span aria-hidden="true">&rarr;</span></a>
														</li>
													</ul>
												</nav>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-md-8">
					
				</div>
				<div class="col-md-4">
					<div class="btn-group">
  <button type="button" class="btn btn-primary">Activate/Diactivate</button>
  <button type="button" class="btn btn-primary">Remove</button>
  <button type="button" class="btn btn-primary">Send Mails</button>
  <button type="button" class="btn btn-primary">Mass Mail</button>
</div>
				</div>
			</div>
		</div>
	</div>
</body>
<?php
include 'res_usrmanagment/modles.php';
?>
</html>