<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/admin/bootstrap.min.css">
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/admin/style.css">
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/admin/lines.css">
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/admin/font-awesome.css">
<script src="{{ url('/') }}/resources/common/js/jquery.min.js"></script>
<link href="//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900" rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/admin/custom.css">
<script src="{{ url('/') }}/resources/common/js/metisMenu.min.js"></script>
<script src="{{ url('/') }}/resources/common/js/custom.js"></script>
<script src="{{ url('/') }}/resources/common/js/d3.v3.js"></script>
<script src="{{ url('/') }}/resources/common/js/rickshaw.js"></script>
<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/lobibox.css">
<script src="{{ url('/') }}/resources/common/js/lobibox.js"></script>

<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/admin/clndr.css">


<link rel="stylesheet" href="{{ url('/') }}/resources/common/css/admin/jqvmap.css">



<!-- jQuery library -->


<!-- Latest compiled JavaScript -->





<script src="{{ url('/') }}/resources/common/js/Chart.js"></script>
<script src="{{ url('/') }}/resources/common/js/clndr.js"></script>



<script src="{{ url('/') }}/resources/common/js/jquery.vmap.js"></script>
<script src="{{ url('/') }}/resources/common/js/jquery.vmap.sampledata.js"></script>

<script src="{{ url('/') }}/resources/common/js/moment-2.2.1.js"></script>

<script src="{{ url('/') }}/resources/common/js/site.js"></script>
<script src="{{ url('/') }}/resources/common/js/underscore-min.js"></script>




<style type="text/css">

	#page-wrapper{
		background-color: rgba(255,255,255,0.9);
	}
	
</style>
<!--nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;" style="border-radius:0px;background:rgba(0,0,0,0.7);border:none;"-->
  <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

  	<script type="text/javascript">
  		$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  	</script>

	@yield('head')
	
</head>

<body >
	<div id="wrapper">
     <!-- Navigation -->
        <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}/home">Wedaduru</a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-nav navbar-right">
				<!--li class="dropdown">
	        		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-comments-o"></i><span class="badge">4</span></a>
	        		<ul class="dropdown-menu">
						<li class="dropdown-menu-header">
							<strong>Messages</strong>
							<div class="progress thin">
							  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
							    <span class="sr-only">40% Complete (success)</span>
							  </div>
							</div>
						</li>
						<li class="avatar">
							<a href="#">
								<img src="{{ url('/') }}/images/1.png" alt=""/>
								<div>New message</div>
								<small>1 minute ago</small>
								<span class="label label-info">NEW</span>
							</a>
						</li>
						<li class="avatar">
							<a href="#">
								<img src="{{ url('/') }}/images/2.png" alt=""/>
								<div>New message</div>
								<small>1 minute ago</small>
								<span class="label label-info">NEW</span>
							</a>
						</li>
						<li class="avatar">
							<a href="#">
								<img src="{{ url('/') }}/images/3.png" alt=""/>
								<div>New message</div>
								<small>1 minute ago</small>
							</a>
						</li>
						<li class="avatar">
							<a href="#">
								<img src="{{ url('/') }}/images/4.png" alt=""/>
								<div>New message</div>
								<small>1 minute ago</small>
							</a>
						</li>
						<li class="avatar">
							<a href="#">
								<img src="{{ url('/') }}/images/5.png" alt=""/>
								<div>New message</div>
								<small>1 minute ago</small>
							</a>
						</li>
						<li class="avatar">
							<a href="#">
								<img src="{{ url('/') }}/images/pic1.png" alt=""/>
								<div>New message</div>
								<small>1 minute ago</small>
							</a>
						</li>
						<li class="dropdown-menu-footer text-center">
							<a href="#">View all messages</a>
						</li>	
	        		</ul>
	      		</li-->
			    <li class="dropdown">
	        		<a href="#" class="dropdown-toggle avatar" data-toggle="dropdown">
	        		@if(! empty($user) && $user->pic!='')

										<img src="../{{$user->pic}}">

									@else
										<img src="{{ url('/') }}../uploads/profile_pics/emp.png">
									@endif
	        		<span class="badge">9</span></a>
	        		<ul class="dropdown-menu">
						<li class="dropdown-menu-header text-center">
							<strong>Account</strong>
						</li>
						
						<li class="m_2"><a href="../profile"><i class="fa fa-user"></i> Profile</a></li>
						
						<li class="divider"></li>
						
						<li class="m_2"><a href="../signout"><i class="fa fa-lock"></i> Logout</a></li>	
	        		</ul>
	      		</li>
			</ul>
			<form class="navbar-form navbar-right">
              <input type="text" class="form-control" value="Search..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search...';}">
            </form>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                        <li>
                            <a href="index.html"><i class="fa fa-dashboard fa-fw nav_icon"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-laptop nav_icon"></i>Layouts<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="grids.html">Grid System</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
							<a href="#"><i class="fa fa-users fa-fw nav_icon"></i>Users<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
                                <li>
                                    <a href="usermanage">Manage</a>
                                </li>
                                <li>
                                    <a href="#">New</a>
                                </li>
                            </ul>
						</li>
						<li>
							<a href="view-ticket"><i class="fa fa-users fa-fw nav_icon"></i>Tickets</a>
						</li>
                        @yield('navigation')
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
				@yield('body')
			

   </div>
      <!-- /#page-wrapper -->
 </div>
 <script src="{{ url('/') }}/resources/common/js/bootstrap.min.js"></script>
	</body>

	</html>