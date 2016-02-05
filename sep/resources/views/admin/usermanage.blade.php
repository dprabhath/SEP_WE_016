@extends('admintemplate/template_admin')

@section('head')
<style type="text/css">
	#wait{

		display:    none;
		position:   fixed;
		z-index:    1000000;
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
<script type="text/javascript">
	const token = "{{ csrf_token() }}";
	var showing_table = 1;
/****************************** send json requets to the server ******************************/
	function jsend(dataString){
		$('#wait').show();
		var datas;
		$.ajax({
			type:"POST",
			url : "{{ url('/') }}/usermanage",
			data:dataString,
			success : function(data){
				document.getElementById("re").innerHTML=data['code']; 
				returnofjsend(data);
				
			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
				Lobibox.notify("error", {
					title: 'Erro',
					msg: 'An erro occurd',
					sound: '../resources/common/sounds/sound4'
				});
				
			}

		},"json");

		
	}

/**************************************** Load Table Types *********************************/
	function loadtable(type){
	 
		if(type=="1"){
			
			var d = {"_token": token ,"task": "loadtableRegisterd"};
			 
			jsend(d);
			
			
		}else if(type=="2"){
			var d = {"_token": token ,"task": "loadtableBlocked"};
			 
			jsend(d);
		}
	}
/*************************************** Getting Json requets from the server ****************************/
	function returnofjsend(data){
		var htmls="";
		$('#wait').hide();
		if(data['code']=="error"){
			Lobibox.notify("warning", {
					title: 'warning',
					msg: data['message'],
					sound: '../resources/common/sounds/sound4'
				});
			return false;
		}



		if(data['task'] == "loadtableRegisterd"){

/*************************  Registerd Users table display ******************************************************/


			$('#ActivateUsers').css("display","none");
			$('#DeleteUsers').css("display","none");
			$('#DeActivateUsers').css("display","block");
			
			var users = data['users'];
			for(var i = 0; i < users.length; i++){


				htmls+= "<tr class='unread checked'>";
				htmls+="<td><input type='checkbox' class='checkbox inside' value="+ users[i]['id'] +"></td>";
				htmls+="<td>"+users[i]['email']+"</td>"
				htmls+="<td><button type='button' class='btn btn-link' style='padding:0px;margin:0px;' value="+users[i]['id']+">Reset Password</button></td>";
				htmls+="<td>"+users[i]['created_at']+"</td></tr>";


				/*
					to get all the users
				$.each( users[i], function( key, value ) {
  						alert( key + ": " + value );
				});
				*/

			}
			showing_table = 1;
			document.getElementById("users_table_registered").innerHTML=htmls; 
			//alert(users[0]['name']);
		}else if(data['task'] == "loadtableBlocked"){
/******************** Blocked User's Display ********************************************************************/
			$('#ActivateUsers').css("display","block");
			$('#DeleteUsers').css("display","block");
			$('#DeActivateUsers').css("display","none");

			var users = data['users'];
			for(var i = 0; i < users.length; i++){


				htmls+= "<tr class='unread checked'>";
				htmls+="<td><input type='checkbox' class='checkbox inside' value="+ users[i]['id'] +"></td>";
				htmls+="<td>"+users[i]['email']+"</td>"
				htmls+="<td><button type='button' class='btn btn-link' style='padding:0px;margin:0px;' value="+users[i]['id']+">Reset Password</button></td>";
				htmls+="<td>"+users[i]['created_at']+"</td></tr>";


				/*
					to get all the users
				$.each( users[i], function( key, value ) {
  						alert( key + ": " + value );
				});
				*/

			}
			showing_table = 2;
			document.getElementById("users_table_registered").innerHTML=htmls; 
		}else if(data['task'] == "resetPassword"){

			Lobibox.notify("success", {
					title: 'success',
					msg: "Password Reseted",
					sound: '../resources/common/sounds/sound4'
				});
		}else if(data['task'] == "DeactivateUsers"){

			loadtable("1");
			Lobibox.notify("success", {
					title: 'success',
					msg: "Deactivated success",
					sound: '../resources/common/sounds/sound4'
				});
		}else if(data['task'] == "ActivateUsers"){

			loadtable("2");
			Lobibox.notify("success", {
					title: 'success',
					msg: "Activated success",
					sound: '../resources/common/sounds/sound4'
				});
		}
		
	}

/***************************************** Refresh views **************************/

	function refresh(){
		//alert("here");
			if(showing_table ==1){
					loadtable("1");
			}else{
				loadtable("2");
			}
	}



/************************* Document Ready Functions *************************************/
	$(document).ready(function(){

		//document.getElementById('fuckdiv').addEventListener('click', refresh);
		loadtable("1");
		//alert("asdas");

		$('#users_table_registered').on('click','button',function(){
			/**
			*
			*Dyanamicaly Generated Table's Reset Password Button Handle
			*
			*
			*/
			var ids=[];
			ids[0] = $(this).attr( "value" );
			var i=0;

			if(ids[0]>0){
				i++;
			}
			if(i===0){
				Lobibox.notify("warning", {
					title: 'warning',
					msg: 'Something went Wrong',
					sound: '../resources/common/sounds/sound4'
				});
				return false;
			}
			var requets = {"_token": token ,"task": "resetPassword","users":ids};
			jsend(requets);

		});
/********************************* select all users function ****************************/
		$('#selectall').click(function(){

			if($(this).prop('checked')==true){
				
				$('.inside').prop('checked', true);
			}else{
				$('.inside').prop('checked', false);
			}

			
			return true;

		});
/********************************** Password reset Function *********************************/
		$('#resetpass').click(function(e){
			e.preventDefault();
			var ids=[];
			var i=0;

			$(".inside").each(function(){
    				if ($(this).prop('checked')==true){ 
       					 ids[i]=$(this).attr( "value" );
       					 i++;
    				}

			});
			if(i===0){
				Lobibox.notify("warning", {
					title: 'warning',
					msg: 'Please Select at least on users',
					sound: '../resources/common/sounds/sound4'
				});
				return false;
			}
			var requets = {"_token": token ,"task": "resetPassword","users":ids};
			jsend(requets);

		});
		
/******************* switch between tables ****************************************/
		$('#BlockedUsers').click(function(e){
			e.preventDefault();
				loadtable("2");

		});
		$('#RegisterdUsers').click(function(e){
			e.preventDefault();
				loadtable("1");

		});

		
/******************************** Users Deactivate Function **********************************/
		$('#DeActivateUsers').click(function(e){
			e.preventDefault();
				var ids=[];
			var i=0;

			$(".inside").each(function(){
    				if ($(this).prop('checked')==true){ 
       					 ids[i]=$(this).attr( "value" );
       					 i++;
    				}

			});
			if(i===0){
				Lobibox.notify("warning", {
					title: 'warning',
					msg: 'Please Select at least on users',
					sound: '../resources/common/sounds/sound4'
				});
				return false;
			}
			var requets = {"_token": token ,"task": "DeactivateUsers","users":ids};
			jsend(requets);

		
		});
		
/******************************* user activate Function *******************************************/
		$('#ActivateUsers').click(function(e){
			e.preventDefault();
				var ids=[];
			var i=0;

			$(".inside").each(function(){
    				if ($(this).prop('checked')==true){ 
       					 ids[i]=$(this).attr( "value" );
       					 i++;
    				}

			});
			if(i===0){
				Lobibox.notify("warning", {
					title: 'warning',
					msg: 'Please Select at least on users',
					sound: '../resources/common/sounds/sound4'
				});
				return false;
			}
			var requets = {"_token": token ,"task": "ActivateUsers","users":ids};
			jsend(requets);

			
		});
/********************************* Refresh Users Table **************************************************/

		
	});

</script>

@stop


@section('navigation')

@stop

@section('body')
<div class="graphs">
	<div class="xs">

		<div class="col-md-12 inbox_right">

			<form action="#" method="GET">
				<div class="input-group">
					<input type="text" name="search" class="form-control1 input-search" placeholder="Search...">
					<span class="input-group-btn">
						<button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
					</span>
				</div><!-- Input Group -->
			</form>
			<div class="mailbox-content">

				<div class="mail-toolbar clearfix"  >
					<div class="float-left" >
						<div class="btn btn_1  mrg5R">
							<input type="checkbox" id="selectall" class="checkbox">
						</div>
						<div class="btn  btn-default mrg5R" onclick='return refresh()'  style="position:relative;float:left;">
							
							<i style=""  class="fa fa-refresh"> </i>
							
							
						</div>
						<div class="dropdown mrg5R" style="position:relative;float:left;">
							<a href="#" title="" class="btn btn-default" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-cog icon_8"></i>
								<i class="fa fa-chevron-down icon_8"></i>
								<div class="ripple-wrapper"></div></a>
								<ul class="dropdown-menu float-right">
									<li>
										<a href="#" title="" id="resetpass">
											<i class="fa fa-pencil-square-o icon_9"></i>
											Reset Password
										</a>
									</li>
									<li id="DeActivateUsers">
										<a href="#" title="">
											<i class="fa fa-calendar icon_9"></i>
											Deactivate
										</a>
									</li>
									<li id="ActivateUsers">
										<a href="#" title="">
											<i class="fa fa-calendar icon_9"></i>
											Activate
										</a>

									</li>
									<li id="DeleteUsers">
										<a href="#" title="">
											<i class="fa fa-calendar icon_9"></i>
											Delete
										</a>
										
									</li>

								</ul>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="float-right">


							<span class="text-muted m-r-sm">Showing 1 of 1 </span>
							<div class="btn-group m-r-sm mail-hidden-options" style="display: inline-block;">
								<div class="btn-group">
									<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-folder"></i> <span class="caret"></span></a>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<li id="RegisterdUsers"><a  href="#">Activated Users</a></li>
										
										<li id="BlockedUsers"><a  href="#">Deactivated Users</a></li>

										<li class="divider"></li>

										<li><a id="Pending Users" href="#">Pending Users</a></li>

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
						<tbody id="users_table_registered">
							
							
						</tbody>
					</table>
				</div>

			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<div id="re">

	</div>
	<div id="wait">

	</div>
	@stop