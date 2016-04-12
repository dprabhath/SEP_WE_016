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
	td {
		max-width: 0;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

</style>
<script type="text/javascript">
	const token = "{{ csrf_token() }}";
	var showing_table = 1;
	var openedTable_count=0;
	var closedTable_count=0;
	var availableTable_count=0;
/****************************** send json requets to the server ******************************/
	function jsend(dataString){
		$('#wait').show();
		var datas;
		$.ajax({
			type:"POST",
			url : "{{ url('/') }}/admin/view-ticket",
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
			
			var d = {"_token": token ,"task": "loadtableopendtickets","skip":openedTable_count};

			jsend(d);
			
			
		}else if(type=="2"){
			var d = {"_token": token ,"task": "loadtableclosedtickets","skip":closedTable_count};

			jsend(d);
		}else if(type=="3"){
			var d = {"_token": token ,"task": "loadtableAvailabletickets","skip":availableTable_count};

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
		if(data['task']=="loadtableopendtickets"){
			$('#action_open_ticket').css("display","none");
			$('#action_close_ticket').css("display","block");
			var tickets = data['tickets'];
			var tot = "Showing Opened Tickets "+(data['skips']*(openedTable_count+1))+" of "+data['total'];
			var last_messages = data['msgs'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(openedTable_count+1)>=totals){
				tot = "Showing Opened Tickets "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			}

			if(openedTable_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			}

			$('#user_count').html(tot);
			for(var i = 0; i < tickets.length; i++){
				htmls+="<tr>";
				htmls+="<td style='width:5%;'><input type='checkbox' id='selectall' value='"+ tickets[i]['id'] +"' class='checkbox inside'></td>";
				htmls+="<td style='width:25%;'>"+ tickets[i]['subject'] +"</td>";
				htmls+=" <td style='width:30%;'>"+ last_messages[i]['message'] +" </td>";
				htmls+="<td style='width:20%;'>"+ last_messages[i]['created_at'] +"</td>";
				htmls+="<td style='width:10%;'><a class='view_ticket_anchor' href='"+tickets[i]['id']+"'>View</a></td>";
				htmls+="<td style='width:10%;''><a class='close_ticket_anchor' href='"+ tickets[i]['id'] +"'>Colse</a></td></tr>";

			}
			showing_table = 1;
			document.getElementById("content_table").innerHTML=htmls;
			

		}else if(data['task']=="loadtableclosedtickets"){
			$('#action_open_ticket').css("display","block");
			$('#action_close_ticket').css("display","none");
			var tickets = data['tickets'];
			var tot = "Showing Closed Tickets "+(data['skips']*(closedTable_count+1))+" of "+data['total'];
			var last_messages = data['msgs'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(closedTable_count+1)>=totals){
				tot = "Showing Closed Tickets "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			}

			if(closedTable_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			}
			$('#user_count').html(tot);
			for(var i = 0; i < tickets.length; i++){
				htmls+="<tr>";
				htmls+="<td style='width:10%;'><input type='checkbox' id='selectall' value='"+ tickets[i]['id'] +"' class='checkbox inside'></td>";
				htmls+="<td style='width:25%;'>"+ tickets[i]['subject'] +"</td>";
				htmls+=" <td style='width:30%;'>"+ last_messages[i]['message'] +" </td>";
				htmls+="<td style='width:15%;'>"+ last_messages[i]['created_at'] +"</td>";
				htmls+="<td style='width:10%;'><a class='view_ticket_anchor' href='"+tickets[i]['id']+"'>View</a></td>";
				htmls+="<td style='width:10%;''><a class='open_ticket_anchor' href='"+ tickets[i]['id'] +"'>Open</a></td></tr>";

			}
			showing_table = 2;
			document.getElementById("content_table").innerHTML=htmls;
		}else if(data['task']=="loadtableAvailabletickets"){
			$('#action_open_ticket').css("display","none");
			$('#action_close_ticket').css("display","none");
			var tickets = data['tickets'];
			var tot = "Showing Available Tickets "+(data['skips']*(availableTable_count+1))+" of "+data['total'];
			var last_messages = data['msgs'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(availableTable_count+1)>=totals){
				tot = "Showing Available Tickets "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			}

			if(availableTable_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			}
			$('#user_count').html(tot);
			for(var i = 0; i < tickets.length; i++){
				htmls+="<tr>";
				htmls+="<td style='width:10%;'><input type='checkbox' id='selectall' value='"+ tickets[i]['id'] +"' class='checkbox inside'></td>";
				htmls+="<td style='width:25%;'>"+ tickets[i]['subject'] +"</td>";
				htmls+=" <td style='width:30%;'>"+ last_messages[i]['message'] +" </td>";
				htmls+="<td style='width:15%;'>"+ last_messages[i]['created_at'] +"</td>";
				htmls+="<td style='width:10%;'><a class='view_ticket_anchor' href='"+tickets[i]['id']+"'>View</a></td>";
				//htmls+="<td style='width:10%;''><a class='open_ticket_anchor' href='"+ tickets[i]['id'] +"'>Open</a></td></tr>";
				htmls+="</tr>";

			}
			showing_table = 3;
			document.getElementById("content_table").innerHTML=htmls;
		}else if(data['task']=="closeTicket"){
			if(showing_table==2){
				loadtable("2");
			}else if(showing_table==3){
				loadtable("3");
			}else{
				loadtable("1");
			}
			Lobibox.notify("success", {
				title: 'success',
				msg: "Tickets closed",
				sound: '../../resources/common/sounds/sound2'
			});
		}else if(data['task']=="openTicket"){
			if(showing_table==2){
				loadtable("2");
			}else if(showing_table==3){
				loadtable("3");
			}else{
				loadtable("1");
			}
			Lobibox.notify("success", {
				title: 'success',
				msg: "Tickets Opened",
				sound: '../../resources/common/sounds/sound2'
			});
		}

	}




	$(document).ready(function(){
		loadtable("1");
		$('#selectall').click(function(){

			if($(this).prop('checked')==true){
				
				$('.inside').prop('checked', true);
			}else{
				$('.inside').prop('checked', false);
			}

			
			return true;

		});


		$('#content_table').on('click','.close_ticket_anchor',function(e){
			///alert($(this).attr('href'));
			e.preventDefault();
			var ids=[];
			ids[0] = $(this).attr('href');
			var requets = {"_token": token ,"task": "closeTicket","tickets":ids};
			jsend(requets);
		});
		$('#content_table').on('click','.open_ticket_anchor',function(e){
			//alert($(this).attr('href'));
			e.preventDefault();
			var ids=[];
			ids[0] = $(this).attr('href');
			var requets = {"_token": token ,"task": "openTicket","tickets":ids};
			jsend(requets);
		});
		$('#content_table').on('click','.view_ticket_anchor',function(e){
			//alert($(this).attr('href'));
			e.preventDefault();
			var ids;
			ids = $(this).attr('href');
			//var requets = {"_token": token ,"task": "viewTicket","ticket":ids};
			//jsend(requets);
			//$('<form action="{{ url('/') }}/admin/view-ticket" method="POST">' + 
			//	'<input type="hidden" name="_token" value="' + token + '">' +
			//	'<input type="hidden" name="ticket" value="' + ids + '">' +
			//	'<input type="hidden" name="task" value="viewTicket">' +
			//	'</form>').submit();
			$('[name=ticket]').attr('value',ids);
			$('#viewform').submit();
		});
		$('#dropdown_menu_opened').click(function(e){
			if(showing_table==2 || showing_table==3){
				loadtable("1");
			}
			e.preventDefault();
		});
		$('#dropdown_menu_closed').click(function(e){
			if(showing_table==1 || showing_table==3){
				loadtable("2");
			}
			e.preventDefault();
		});
		$('#dropdown_menu_available').click(function(e){
			if(showing_table==1 || showing_table==2){
				loadtable("3");
			}
			e.preventDefault();
		});
		$('.refresh_button').click(function(){
			if(showing_table==2){
				loadtable("2");
			}else if(showing_table==3){
				loadtable("3");
			}else{
				loadtable("1");
			}
		});
		


		/************************************ Close tickets/Open Tickets *******************************/
		$('#action_close_ticket').click(function(e){
			e.preventDefault();
			var ids=[];
			var i=0;

			$(".inside").each(function(){
				if ($(this).prop('checked')==true){ 
					ids[i]=$(this).attr( "value" );
					i++;
				}

			});
			if(i==0){
				Lobibox.notify("warning", {
					title: 'warning',
					msg: 'Please Select at least one users',
					sound: '../../resources/common/sounds/sound4'
				});
				return false;
			}
			var requets = {"_token": token ,"task": "closeTicket","tickets":ids};
			jsend(requets);

			
		});
		$('#action_open_ticket').click(function(e){
			e.preventDefault();
			var ids=[];
			var i=0;

			$(".inside").each(function(){
				if ($(this).prop('checked')==true){ 
					ids[i]=$(this).attr( "value" );
					i++;
				}

			});
			if(i==0){
				Lobibox.notify("warning", {
					title: 'warning',
					msg: 'Please Select at least one users',
					sound: '../../resources/common/sounds/sound4'
				});
				return false;
			}
			var requets = {"_token": token ,"task": "openTicket","tickets":ids};
			jsend(requets);

		});
		$('#buttton_previous').click(function(e){
			if(showing_table ==1){
				openedTable_count--;

				loadtable("1");

			}else if(showing_table==2){
				closedTable_count--;
				loadtable("2");
			}else{
				availableTable_count--;
				loadtable("3");
			}

		});
		$('#buttton_next').click(function(e){
			if(showing_table ==1){
				openedTable_count++;
				
				loadtable("1");

			}else if(showing_table==2){
				closedTable_count++;
				loadtable("2");

			}else{
				availableTable_count++;
				loadtable("3");
			}

		});
		

	});
</script>
@stop


@section('navigation')

@stop

@section('body')
<form id="viewform" style="display: none;" action="{{ url('/') }}/admin/view-ticket" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="ticket" value="">
				<input type="hidden" name="task" value="viewTicket">
				</form>
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
						<div class="btn  btn-default mrg5R refresh_button"   style="position:relative;float:left;">
							
							<i style=""  class="fa fa-refresh"> </i>
							
							
						</div>
						<div class="dropdown mrg5R" style="position:relative;float:left;">
							<a href="#" title="" class="btn btn-default" data-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-cog icon_8"></i>
								<i class="fa fa-chevron-down icon_8"></i>
								<div class="ripple-wrapper"></div></a>
								<ul class="dropdown-menu float-right">
									<li>
										<a href="#" title="" id="action_close_ticket">
											<i class="fa fa-pencil-square-o icon_9"></i>
											Close
										</a>
									</li>
									<li id="action_open_ticket">
										<a href="#" title="">
											<i class="fa fa-calendar icon_9"></i>
											Open
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
										<li id="dropdown_menu_opened"><a  href="#">Opend tickets</a></li>
										
										<li id="dropdown_menu_closed"><a  href="#">Closed Tickets</a></li>

										<li id="dropdown_menu_available"><a  href="#">Available Tickets</a></li>

									

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
						<tbody id="content_table">
							
							
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
{!! Form::open() !!}
<!--input type="text" name="ticket_id" value="">
<input type="text" name="task" value="">
<div class="form-group">
								<label for="exampleInputEmail1">Reply:</label>
								<textarea id="replyText" class="form-control" rows="4" style="border:1px solid black !important;border-radius:0px !important;background-color:rgba(0,0,0,0.1) !important;"></textarea>
							</div>
<input type="submit"-->
{!! Form::close() !!}
	@stop