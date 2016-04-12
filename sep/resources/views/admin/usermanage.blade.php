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
		url('{{ url('/') }}/resources/common/gif/ajax-loader.gif') 
		50% 50% 
		no-repeat;


	}

</style>
<script type="text/javascript">
	const token = "{{ csrf_token() }}";
	var loadTableRegisterd_count=0;
	var loadTableBlocked_count=0;
	var loadTablePending_count=0;
	var showing_table = 1;
/****************************** send json requets to the server ******************************/
	function jsend(dataString){
		$('#wait').show();
		var datas;
		$.ajax({
			type:"POST",
			url : "{{ url('/') }}/admin/usermanage",
			data:dataString,
			success : function(data){
				//document.getElementById("re").innerHTML=data['code']; 
				returnofjsend(data);
				
			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
				$('#wait').hide();
				Lobibox.notify("error", {
					title: 'Erro',
					msg: 'An erro occurd',
					sound: '../../resources/common/sounds/sound4'
				});
				
			}

		},"json");

		
	}

/**************************************** Load Table Types *********************************/
	function loadtable(type){
	 
		if(type=="1"){
			
			var d = {"_token": token ,"task": "loadtableRegisterd","skip":loadTableRegisterd_count};
			 
			jsend(d);
			
			
		}else if(type=="2"){
			var d = {"_token": token ,"task": "loadtableBlocked","skip":loadTableBlocked_count};
			 
			jsend(d);
		}else if(type=="3"){
			var d = {"_token": token ,"task": "loadtablePending","skip":loadTablePending_count};
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
					sound: '../../resources/common/sounds/sound4'
				});
			return false;
		}



		if(data['task'] == "loadtableRegisterd"){

/*************************  Registerd Users table display ******************************************************/


			$('#ActivateUsers').css("display","none");
			//$('#DeleteUsers').css("display","none");
			$('#DeActivateUsers').css("display","block");
			$('#DeleteUsers').css("display","none");
			$('#ConfirmUsers').css("display","none");

			var users = data['users'];
			var tot = "Showing Registed Users "+(data['skips']*(loadTableRegisterd_count+1))+" of "+data['total'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(loadTableRegisterd_count+1)>=totals){
				tot = "Showing Registed Users "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			} 

			if(loadTableRegisterd_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			}
			$('#user_count').html(tot);
			for(var i = 0; i < users.length; i++){


				htmls+= "<tr class='unread checked'>";
				htmls+="<td><input type='checkbox' class='checkbox inside' value="+ users[i]['id'] +"></td>";
				htmls+="<td>"+users[i]['email']+"</td>"
				htmls+="<td><button id='repassword' type='button' class='btn btn-link' style='padding:0px;margin:0px;' value="+users[i]['id']+">Reset Password</button></td>";
				htmls+="<td>"+users[i]['created_at']+"</td>";
				htmls+="<td><button id='userlevelchange' type='button' class='btn btn-link' style='padding:0px;margin:0px;' value="+users[i]['id']+">";
				if(users[i]['level']==10){
					htmls+="Admin";
				}else if(users[i]['level']==2){
					htmls+="Doctor";
				}else if(users[i]['level']==1){
					htmls+="User";
				}else{
					htmls+="Moderator";
				}
				htmls+="</button></td></tr>";

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
			//$('#DeleteUsers').css("display","block");
			$('#DeActivateUsers').css("display","none");
			$('#DeleteUsers').css("display","none");
			$('#ConfirmUsers').css("display","none");
			
			var users = data['users'];
			var tot = "Showing blocked Users "+(data['skips']*(loadTableBlocked_count+1))+" of "+data['total'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(loadTableBlocked_count+1)>=totals){
				tot = "Showing blocked Users "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			}
			if(loadTableBlocked_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			} 
			$('#user_count').html(tot);
			for(var i = 0; i < users.length; i++){
				htmls+= "<tr class='unread checked'>";
				htmls+="<td><input type='checkbox' class='checkbox inside' value="+ users[i]['id'] +"></td>";
				htmls+="<td>"+users[i]['email']+"</td>"
				htmls+="<td><button id='repassword' type='button' class='btn btn-link' style='padding:0px;margin:0px;' value="+users[i]['id']+">Reset Password</button></td>";
				htmls+="<td>"+users[i]['created_at']+"</td>";

				htmls+="<td><button id='userlevelchange' type='button' class='btn btn-link' style='padding:0px;margin:0px;' value="+users[i]['id']+">";
				if(users[i]['level']==10){
					htmls+="Admin";
				}else if(users[i]['level']==2){
					htmls+="Doctor";
				}else if(users[i]['level']==1){
					htmls+="User";
				}else{
					htmls+="Moderator";
				}
				htmls+="</button></td></tr>";
			}
			showing_table = 2;
			document.getElementById("users_table_registered").innerHTML=htmls; 
		}else if(data['task'] == "loadtablePending"){
/******************** Blocked User's Display ********************************************************************/
			$('#ActivateUsers').css("display","none");
			//$('#DeleteUsers').css("display","block");
			$('#DeActivateUsers').css("display","none");
			$('#DeleteUsers').css("display","block");
			$('#ConfirmUsers').css("display","block");
			
			var users = data['users'];
			var tot = "Showing pending users "+(data['skips']*(loadTablePending_count+1))+" of "+data['total'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(loadTablePending_count+1)>=totals){
				tot = "Showing pending users "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			}
			if(loadTablePending_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			} 
			$('#user_count').html(tot);
			for(var i = 0; i < users.length; i++){
				htmls+= "<tr class='unread checked'>";
				htmls+="<td><input type='checkbox' class='checkbox inside' value="+ users[i]['id'] +"></td>";
				htmls+="<td>"+users[i]['email']+"</td>"
				htmls+="<td><button id='repassword' type='button' class='btn btn-link' style='padding:0px;margin:0px;' value="+users[i]['id']+">Reset Password</button></td>";
				htmls+="<td>"+users[i]['created_at']+"</td>";

				htmls+="<td><button id='userlevelchange' type='button' class='btn btn-link' style='padding:0px;margin:0px;' value="+users[i]['id']+">";
				if(users[i]['level']==10){
					htmls+="Admin";
				}else if(users[i]['level']==2){
					htmls+="Doctor";
				}else if(users[i]['level']==1){
					htmls+="User";
				}else{
					htmls+="Moderator";
				}
				htmls+="</button></td></tr>";
			}
			showing_table = 3;
			document.getElementById("users_table_registered").innerHTML=htmls; 
		}else if( data['task'] == "resetPassword" ){

			Lobibox.notify("success", {
					title: 'success',
					msg: "Password Reseted",
					sound: '../../resources/common/sounds/sound2'
				});
		}else if( data['task']=="DeactivateUsers" ){

			loadtable("1");
			Lobibox.notify("success", {
					title: 'success',
					msg: "Deactivated success",
					sound: '../../resources/common/sounds/sound2'
				});
		}else if( data['task']=="ActivateUsers" ){

			loadtable("2");
			Lobibox.notify("success", {
					title: 'success',
					msg: "Activated success",
					sound: '../../resources/common/sounds/sound2'
				});
		}else if( data['task']=="ConfirmUsers" ){

			loadtable("3");
			Lobibox.notify("success", {
					title: 'success',
					msg: "Users Confirm success",
					sound: '../../resources/common/sounds/sound2'
				});
		}else if( data['task']=="DeleteUsers" ){

			loadtable("3");
			Lobibox.notify("success", {
					title: 'success',
					msg: "Users Delete success",
					sound: '../../resources/common/sounds/sound2'
				});
		}else if( data['task']=="changeRole" ){

			refresh();
			Lobibox.notify("success", {
					title: 'success',
					msg: "Users Role Updated",
					sound: '../../resources/common/sounds/sound2'
				});
		}
		
	}

/***************************************** Refresh views **************************/

	function refresh(){
		//alert("here");
			if(showing_table ==1){
					loadtable("1");
			}else if(showing_table==2){
				loadtable("2");
			}else{
				loadtable("3");
			}
	}



/************************* Document Ready Functions *************************************/
	$(document).ready(function(){

		
		loadtable("1");

		//alert("asdas");

		$('#users_table_registered').on('click','#repassword',function(){
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
					sound: '../../resources/common/sounds/sound4'
				});
				return false;
			}
			var requets = {"_token": token ,"task": "resetPassword","users":ids};
			jsend(requets);

		});
		$('#users_table_registered').on('click','#userlevelchange',function(){
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
					sound: '../../resources/common/sounds/sound4'
				});
				return false;
			}

			 Lobibox.alert('info', {
			    msg: 'Change the Role Below',
			    //buttons: ['ok', 'cancel', 'yes', 'no'],
			    //Or more powerfull way
			    buttons: {
			        no: {
			            'class': 'btn btn-info',
			            closeOnClick: true,
			            text: 'Admin'
			        },
			        load: {
			            'class': 'btn btn-info',
			            closeOnClick: true,
			            text: 'Moderator'
			        },
			        yes: {
			            'class': 'btn btn-info',
			            closeOnClick: true,
			            text: 'Doctor'
			        },
			        ok: {
			            'class': 'btn btn-info',
			            closeOnClick: true,
			            text: 'User'
			        }
			    },
			    callback: function(lobibox, type){
			        var btnType;
			        if (type === 'no'){
			            btnType = 'Admin';
			        }else if (type === 'yes'){
			            btnType = 'Doctor';
			        }else if (type === 'load'){
			            btnType = 'Moderator';
			        }else{
			        	btnType = 'User';
			        }
			        Lobibox.confirm({
		    			msg: "Are you sure you want chnage the role to "+ btnType+" ?",
		    			callback: function ($this, type, ev) {
		        			if (type === 'no'){
			    				return false;
			    			}else{
			    				 var requets = {"_token": token ,"task": "changeRole","users":ids,"role":btnType};
								 jsend(requets);
			    			}
		    			}
					});
			       
			    }
			});
			
			

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
					msg: 'Please Select at least one users',
					sound: '../../resources/common/sounds/sound4'
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
		$('#PendingUsers').click(function(e){
			e.preventDefault();
			
				loadtable("3");

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
					msg: 'Please Select at least one users',
					sound: '../../resources/common/sounds/sound4'
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
					msg: 'Please Select at least one users',
					sound: '../../resources/common/sounds/sound4'
				});
				return false;
			}
			var requets = {"_token": token ,"task": "ActivateUsers","users":ids};
			jsend(requets);

			
		});
/********************************************* confirm users ***************************************/
		$('#ConfirmUsers').click(function(e){
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
					msg: 'Please Select at least one users',
					sound: '../../resources/common/sounds/sound4'
				});
				return false;
			}
			var requets = {"_token": token ,"task": "ConfirmUsers","users":ids};
			jsend(requets);

			
		});
/********************************************* Delete users ***************************************/
		$('#DeleteUsers').click(function(e){
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
					msg: 'Please Select at least one users',
					sound: '../../resources/common/sounds/sound4'
				});
				return false;
			}
			
			Lobibox.confirm({
    			msg: "Are you sure you want to delete this user?",
    			callback: function ($this, type, ev) {
        			if (type === 'no'){
	    				return false;
	    			}else{
	    				var requets = {"_token": token ,"task": "DeleteUsers","users":ids};
						jsend(requets);
	    			}
    			}
			});
			
		});
/********************************* Search **************************************************/
		$('form#search').submit(function(e){
			
			var strings = $('[name=searchBox]').val();
			
			var tasktype = 1;
			if(showing_table ==1){
				tasktype = 1;
			}else{
				tasktype = 2;
			}
			var requets = {"_token": token ,"task": "search","searchString":strings,"tasktype":tasktype};
			e.preventDefault();
			jsend(requets);

		});

		$('#buttton_previous').click(function(e){
			if(showing_table ==1){
				loadTableRegisterd_count--;

				loadtable("1");

			}else if(showing_table==2){
				loadTableBlocked_count--;
				loadtable("2");
			}else{
				loadTablePending_count--;
				loadtable("3");
			}

		});
		$('#buttton_next').click(function(e){
			if(showing_table ==1){
				loadTableRegisterd_count++;
				
				loadtable("1");

			}else if(showing_table==2){
				loadTableBlocked_count++;
				loadtable("2");

			}else{
				loadTablePending_count++;
				loadtable("3");
			}

		});
		
	});

</script>

@stop


@section('navigation')

@stop

@section('body')
<div class="graphs">
	<div class="xs">

		<div class="col-md-12 inbox_right">

			<form id="search">
				<div class="input-group">
					<input type="text" name="searchBox" class="form-control1 input-search" placeholder="Search...">
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
									<li id="ConfirmUsers">
										<a href="#" title="">
											<i class="fa fa-calendar icon_9"></i>
											Confirm
										</a>

									</li>
									

								</ul>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="float-right">


							<span id="user_count" class="text-muted m-r-sm"> </span>
							<div class="btn-group m-r-sm mail-hidden-options" style="display: inline-block;">
								<div class="btn-group">
									<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-folder"></i> <span class="caret"></span></a>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<li id="RegisterdUsers"><a  href="#">Activated Users</a></li>
										
										<li id="BlockedUsers"><a  href="#">Deactivated Users</a></li>

										<li class="divider"></li>

										<li id="PendingUsers"><a  href="#">Pending Users</a></li>

									</ul>
								</div>
							</div>
							<div class="btn-group">
								<a id="buttton_previous" class="btn btn-default"><i class="fa fa-angle-left"></i></a>
								<a id="buttton_next" class="btn btn-default"><i class="fa fa-angle-right"></i></a>
							</div>


						</div>
					</div>
					<div class="table-responsive">
					<table class="table">
						<tbody id="users_table_registered">
							
							
						</tbody>
					</table>
					</div>
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