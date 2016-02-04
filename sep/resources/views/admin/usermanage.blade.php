@extends('admintemplate/template_admin')

@section('head')
@stop


@section('navigation')
<li>
	<a href="usermanage"><i class="fa fa-users fa-fw nav_icon"></i>User Manage</a>
</li>
@stop

@section('body')
<div class="graphs">
	     <div class="xs">
<div class="col-md-4">
		<div class="list-group list-group-alternate"> 
			<a href="#home" class="list-group-item"><i class="ti ti-email"></i> Profile </a> 
			<a href="#menu1" class="list-group-item"><span class="badge badge-warning">4.5/5</span>Rating </a> 
			<a href="#menu1" class="list-group-item"><span class="badge badge-warning">14</span> Posts created </a>
			<a href="#menu1" class="list-group-item"><span class="badge badge-warning">100</span>Contributions </a> 
			<a href="#menu1" class="list-group-item"><span class="badge badge-warning">14</span> Messages </a> 
			<a href="#menu1" class="list-group-item"><span class="badge badge-danger">30</span>Notifications </a> 
		</div>
</div>
<div class="col-md-8 inbox_right">
	<form action="#" method="GET">
		<div class="input-group">
			<input type="text" name="search" class="form-control1 input-search" placeholder="Search...">
			<span class="input-group-btn">
				<button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
			</span>
		</div><!-- Input Group -->
	</form>
	<div class="mailbox-content">
		<div class="mail-toolbar clearfix">
			<div class="float-left">
				<div class="btn btn_1 btn-default mrg5R">
					<i class="fa fa-refresh"> </i>
				</div>
				<div class="dropdown">
					<a href="#" title="" class="btn btn-default" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-cog icon_8"></i>
						<i class="fa fa-chevron-down icon_8"></i>
						<div class="ripple-wrapper"></div></a>
						<ul class="dropdown-menu float-right">
							<li>
								<a href="#" title="">
									<i class="fa fa-pencil-square-o icon_9"></i>
									Edit
								</a>
							</li>
							<li>
								<a href="#" title="">
									<i class="fa fa-calendar icon_9"></i>
									Schedule
								</a>
							</li>
							<li>
								<a href="#" title="">
									<i class="fa fa-download icon_9"></i>
									Download
								</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" class="font-red" title="">
									<i class="fa fa-times" icon_9=""></i>
									Delete
								</a>
							</li>
						</ul>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="float-right">


					<span class="text-muted m-r-sm">Showing 20 of 346 </span>
					<div class="btn-group m-r-sm mail-hidden-options" style="display: inline-block;">
						<div class="btn-group">
							<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-folder"></i> <span class="caret"></span></a>
							<ul class="dropdown-menu dropdown-menu-right" role="menu">
								<li><a href="#">Social</a></li>
								<li><a href="#">Forums</a></li>
								<li><a href="#">Updates</a></li>
								<li class="divider"></li>
								<li><a href="#">Spam</a></li>
								<li><a href="#">Trash</a></li>
								<li class="divider"></li>
								<li><a href="#">New</a></li>
							</ul>
						</div>
						<div class="btn-group">
							<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tags"></i> <span class="caret"></span></a>
							<ul class="dropdown-menu dropdown-menu-right" role="menu">
								<li><a href="#">Work</a></li>
								<li><a href="#">Family</a></li>
								<li><a href="#">Social</a></li>
								<li class="divider"></li>
								<li><a href="#">Primary</a></li>
								<li><a href="#">Promotions</a></li>
								<li><a href="#">Forums</a></li>
							</ul>
						</div>
					</div>
					<div class="btn-group">
						<a class="btn btn-default"><i class="fa fa-angle-left"></i></a>
						<a class="btn btn-default"><i class="fa fa-angle-right"></i></a>
					</div>


				</div>
			</div>
			<table class="table">
				<tbody>
					<tr class="unread checked">
						<td class="hidden-xs">
							<input type="checkbox" class="checkbox">
						</td>
						<td class="hidden-xs">
							<i class="fa fa-star icon-state-warning"></i>
						</td>
						<td class="hidden-xs">
							Google
						</td>
						<td>
							Nullam quis risus eget urna mollis ornare vel eu leo
						</td>
						<td>
						</td>
						<td>
							12 march
						</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
	<div class="clearfix"> </div>
</div>
</div>
@stop