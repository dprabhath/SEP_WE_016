<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/bootstrap.css">
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/clndr.css">
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/custom.css">
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/font-awesome.css">
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/jqvmap.css">
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/lines.css">
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/style.css">
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/lobibox.css">

<!-- jQuery library -->


<!-- Latest compiled JavaScript -->



<script src="{{ url('/') }}/resources/common/js/jquery.min.js"></script>
<script src="{{ url('/') }}/resources/common/js/bootstrap.min.js"></script>
<script src="{{ url('/') }}/resources/common/js/Chart.js"></script>
<script src="{{ url('/') }}/resources/common/js/clndr.js"></script>
<script src="{{ url('/') }}/resources/common/js/custom.js"></script>
<script src="{{ url('/') }}/resources/common/js/d3.v3.js"></script>

<script src="{{ url('/') }}/resources/common/js/jquery.vmap.js"></script>
<script src="{{ url('/') }}/resources/common/js/jquery.vmap.sampledata.js"></script>
<script src="{{ url('/') }}/resources/common/js/metisMenu.min.js"></script>
<script src="{{ url('/') }}/resources/common/js/moment-2.2.1.js"></script>
<script src="{{ url('/') }}/resources/common/js/rickshaw.js"></script>
<script src="{{ url('/') }}/resources/common/js/site.js"></script>
<script src="{{ url('/') }}/resources/common/js/underscore-min.js"></script>
<script src="{{ url('/') }}/resources/common/js/lobibox.js"></script>
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
  padding: 8px; /* firefox bug fix */
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
.navbar {
min-height:70px !important;
-webkit-box-shadow: 0 8px 6px -6px #999 !important;;
    -moz-box-shadow: 0 8px 6px -6px #999 !important;;
    box-shadow: 0 8px 6px -6px #999 !important;;

}

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
  



	@yield('head')
	
</head>

<body >
	<div id="wrapper" class="container-fluid r3_counter_box"  align="center">
		
		<div id="header" align="left">
		<div class="container-fluid" style="min-height:30px;background:rgb(0,0,0);border:none;"></div>
			<nav class="navbar navbar-default" style="border-radius:0px;background:rgba(255,255,255,1);border:none;">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span> 
						</button>
						<a class="navbar-brand" href="#" ><img src="{{ url('/') }}/resources/common/picutres/m_logo_primary_rwd.png" style="max-height:100%;width:auto;"></a>
					</div>
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav navbar-right">
							<li class="active"><a href="#">Home</a></li>
							<li><a href="#">Page 1</a></li>
							<li><a href="#">Page 2</a></li> 
							<li><a href="#">Page 3</a></li> 
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">


								@if(! empty($user) && $user->pic!='')

										<img src={{$user->pic}} class="profile-image img-circle custom_profile_pic">

									@else
										<img src="{{ url('/') }}/uploads/profile_pics/emp.png" class="profile-image img-circle custom_profile_pic">
									@endif

									<b class="caret"></b></a>
									<!--img src="http://placehold.it/60x60" class="profile-image img-circle custom_profile_pic"> Username <b class="caret"></b></a-->
									<ul class="dropdown-menu">
										<li><a href="#"><span class="glyphicon glyphicon-user"></span> Username</a></li>
										<li><a href="#"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
										<li class="divider"></li>
										<li><a href="index.php"><span class="glyphicon glyphicon-log-out"></span> Sign-out</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</nav>
				@yield('navbar')
			</div><!-- #header -->

			<div id="content" align="left">
				@yield('body')
			</div><!-- #content -->

			<div id="footer" align="center">
			All Rights Reserved 2016. XiCigny (Pvt) Ltd
				@yield('footer')
			</div><!-- #footer -->

		</div><!-- #wrapper -->
	</body>

	</html>