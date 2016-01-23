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
		
		.hiders{
			visibility: visible;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function() {

			$('.tab_menu').click(function(){
				//alert($(this).attr('href'));
				var menu = $(this).attr('href');
				if(menu == "#menu1"){
					$('.hiders').css({"visibility": "visible"});
				}else{
					$('.hiders').css({"visibility": "hidden"});
				}
    // or alert($(this).hash();
});


		});

	</script>
</head>

<body class="bodybg">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6"></div>
				<div class="col-sm-6 hidden-sm hidden-xs">
					<div class="input-group hiders" style="width:100%;">
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
						<li class="active"><a class="tab_menu" data-toggle="pill" href="#menu1">View Registered Users</a></li>
						<li ><a class="tab_menu" data-toggle="pill" href="#home">New User</a></li>
						
					</ul>
				</div>
				<div class="col-md-9">
					<div class="tab-content" style="width:100%;min-width:100%;max-width:100%;">
						
						<div id="menu1" class="tab-pane fade in active" style="wdith:100%;">
							<table class="table table-hover" style="table-layout: fixed;width:100%;min-width:100%;" border="0">
								<thead>
									<tr style="width:100%;visibility: hidden;">
										<th class="col-md-1 col-sm-1 col-xs-1"></th>
										<th class="col-md-4 col-sm-3 col-xs-2" ></th>
										<th class="col-md-5 col-sm-6 col-xs-6"></th>
										<th class="col-md-2 col-sm-2 col-xs-3"></th>
									</tr>
								</thead>
								<tbody class="ellipsis">
									<tr>
										<td colspan="4" style="width:100%;" class="hidden-lg hidden-md" >
											<div class="input-group hiders" style="width:100%;">

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
											Sleepy
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
						<div id="home" class="tab-pane fade in " style="max-wdith:100%;">
							registration form
						</div>
					</div>
				</div>
			</div>


			<div class="row hiders">
				<div class="col-md-3 hidden-xs hidden-sm">
					
				</div>
				<div class="col-md-9 col-xs-12 col-sm-12" align="center">
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