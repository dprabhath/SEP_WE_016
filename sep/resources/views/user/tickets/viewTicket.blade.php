@extends('template/template_user')

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

	#dbox,#buttton_previous,#buttton_next{
		background-color:#fff;
		padding:10px;
		height:40px;
		border-width:1px;
		border-style:solid;
		border-bottom-color:#ddd;
		border-right-color:#ddd;
		border-top-color:#ddd;
		border-left-color:#ddd;
		border-radius:3px;
		-moz-border-radius:3px;
		-webkit-border-radius:3px;


	}
	#dboxpadding{
		background-color:#fff;
		padding:10px;
		height:40px;
		border-width:1px;
		border-style:solid;
		border-bottom-color:#ddd;
		border-right-color:#ddd;
		border-top-color:#ddd;
		border-left-color:#ddd;
		border-radius:3px;
		-moz-border-radius:3px;
		-webkit-border-radius:3px;


	}
	td {
		/*max-width: 0;
		overflow: hidden;
		text-overflow: ellipsis;*/
		white-space: nowrap;
	}
</style>

<script type="text/javascript">
	const token = "{{ csrf_token() }}";
	var showing_table = 1;
	var loadtableopendtickets_count=0;
	var loadtableclosedtickets_count=0;
	/****************************** send json requets to the server ******************************/
	function jsend(dataString){
		$('#wait').show();
		var datas;
		$.ajax({
			type:"POST",
			url : "{{ url('/') }}/view-ticket",
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
					sound: '../resources/common/sounds/sound4'
				});
				
			}

		},"json");

		
	}
	/**************************************** Load Table Types *********************************/
	function loadtable(type){

		if(type=="1"){
			
			var d = {"_token": token ,"task": "loadtableopendtickets","skip":loadtableopendtickets_count};

			jsend(d);
			
			
		}else if(type=="2"){
			var d = {"_token": token ,"task": "loadtableclosedtickets","skip":loadtableclosedtickets_count};

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

			var tickets = data['tickets'];
			var tot = "Showing Opened Tickets "+(data['skips']*(loadtableopendtickets_count+1))+" of "+data['total'];
			var last_messages = data['msgs'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(loadtableopendtickets_count+1)>=totals){
				tot = "Showing Opened Tickets "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			} 

			if(loadtableopendtickets_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			}
			$('.showtotal').html(tot);
			for(var i = 0; i < tickets.length; i++){
				htmls+="<tr>";
				htmls+="<td ><input type='checkbox' id='selectall' value='"+ tickets[i]['id'] +"' class='checkbox inside'></td>";
				htmls+="<td >"+ tickets[i]['subject'] +"</td>";
				htmls+=" <td >"+ last_messages[i]['message'] +" </td>";
				htmls+="<td >"+ last_messages[i]['created_at'] +"</td>";
				htmls+="<td ><a class='view_ticket_anchor' href='"+tickets[i]['id']+"'>View</a></td>";
				htmls+="<td ><a class='close_ticket_anchor' href='"+ tickets[i]['id'] +"'>Colse</a></td></tr>";

			}
			showing_table = 1;
			document.getElementById("content_table").innerHTML=htmls;
			

		}else if(data['task']=="loadtableclosedtickets"){
			var tickets = data['tickets'];
			var tot = "Showing Closed Tickets "+(data['skips']*(loadtableclosedtickets_count+1))+" of "+data['total'];
			var last_messages = data['msgs'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(loadtableclosedtickets_count+1)>=totals){
				tot = "Showing Closed Tickets "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			} 

			if(loadtableclosedtickets_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			}
			$('.showtotal').html(tot);
			for(var i = 0; i < tickets.length; i++){
				htmls+="<tr>";
				htmls+="<td><input type='checkbox' id='selectall' value='"+ tickets[i]['id'] +"' class='checkbox inside'></td>";
				htmls+="<td >"+ tickets[i]['subject'] +"</td>";
				htmls+=" <td >"+ last_messages[i]['message'] +" </td>";
				htmls+="<td >"+ last_messages[i]['created_at'] +"</td>";
				htmls+="<td ><a class='view_ticket_anchor' href='"+tickets[i]['id']+"'>View</a></td>";
				htmls+="<td><a class='open_ticket_anchor' href='"+ tickets[i]['id'] +"'>Open</a></td></tr>";

			}
			showing_table = 2;
			document.getElementById("content_table").innerHTML=htmls;
		}else if(data['task']=="closeTicket"){
			if(showing_table==2){
				loadtable("2");
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
	/*************************************** Main Jquery Handler ****************************/
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
			
			var ids;
			ids = $(this).attr('href');
			//var requets = {"_token": token ,"task": "viewTicket","ticket":ids};
			//jsend(requets);
			//$('<form action="{{ url('/') }}/view-ticket" method="POST">' + 
			//	'<input type="hidden" name="_token" value="' + token + '">' +
			//	'<input type="hidden" name="ticket" value="' + ids + '">' +
			//	'<input type="hidden" name="task" value="viewTicket">' +
			//	'</form>').submit();
			$('[name=ticket]').attr('value',ids);
			$('#viewform').submit();

			e.preventDefault();
		});
		$('#dropdown_menu_opened').click(function(e){
			if(showing_table==2){
				loadtable("1");
			}
			e.preventDefault();
		});
		$('#dropdown_menu_closed').click(function(e){
			if(showing_table==1){
				loadtable("2");
			}
			e.preventDefault();
		});
		$('.refresh_button').click(function(){
			if(showing_table==2){
				loadtable("2");
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
				loadtableopendtickets_count--;

				loadtable("1");
			}else{
				loadtableclosedtickets_count--;
				loadtable("2");
			}

		});

		$('#buttton_next').click(function(e){
			if(showing_table ==1){
				loadtableopendtickets_count++;
				
				loadtable("1");

			}else{
				loadtableclosedtickets_count++;
				loadtable("2");
			}

		});
		

	});

</script>

@stop
@section('navbar')
@stop
@section('body')
<form id="viewform" style="display: none;" action="{{ url('/') }}/view-ticket" method="POST"> 
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="ticket" value="">
				<input type="hidden" name="task" value="viewTicket">
</form>
<div class="row">
	<div class="container-fluid">
		<div class="col-sm-8">

		</div>
		<div class="col-sm-4">
			<!--div class="input-group" style="border-radius:0px !important;">
				<input type="text" class="form-control" placeholder="&#xf002;" style="font-family: 'FontAwesome';border-radius:0px !important;">
				
			</div-->
		</div>
		
	</div>
</div>
<div class="container-fluid" style="background:#fff;padding-top:50px;">

	<div class="row">
		<div class="col-xs-12" style="padding:4px;">
			<div class="row">
				<div class="col-xs-12">
					<div class="container" style="max-width:100%;">
						<div id="dbox" style="float:left;padding-right:15px;border-color: #fff;">
							<input type="checkbox" id="selectall" class="checkbox">
						</div>
						<div id="dbox" style="float:left;border-color: #fff;padding:5px;">
						</div>
						<div id="dbox" style="float:left;" class="refresh_button">
							<span class="glyphicon glyphicon glyphicon-refresh" aria-hidden="true"></span>
						</div>
						<div id="dbox" style="float:left;border-color: #fff;padding:2px;">
						</div>

						<div id="dbox" class="dropdown" style="float:left;padding:0px;padding-top:10px;">

							<a href="#" style="padding:10px;margin:0px;border:0px solid black;padding-bottom:5px;padding-top:8px;color:black;" data-toggle="dropdown"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
								<span class="caret"></span>
							</a>

							<ul class="dropdown-menu">
								<li id="action_close_ticket"><a href="#">Close</a></li>
								<li id="action_open_ticket"><a href="#">Open</a></li>
								
							</ul>
						</div>







						<div id="buttton_next" style="float:right;font-size: 12px;padding-top:12px;">
							<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
						</div>
						<div id="buttton_previous" style="float:right;font-size: 12px;padding-top:12px;">
							<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
						</div>
						<div id="dbox" style="float:right;border-color: #fff;padding:7px;">
						</div>


						<div id="dbox" class="dropdown" style="float:right;padding:0px;padding-top:10px;">

							<a href="#" style="padding:10px;margin:0px;border:0px solid black;padding-bottom:5px;padding-top:8px;color:black;" data-toggle="dropdown"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
								<span class="caret"></span>
							</a>

							<ul class="dropdown-menu">
								<li><a id="dropdown_menu_opened" href="#">Opened</a></li>
								<li><a id="dropdown_menu_closed" href="#">Closed</a></li>
							</ul>
						</div>

						<div id="dbox" style="float:right;border-color: #fff;padding:7px;">
						</div>
						<div id="dbox" class="showtotal" style="float:right;font-size: 12px;padding-top:12px;color:grey;border-color: #fff;">
							Showing 0 of 0
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row" style="max-width:100%;">
		<div class="container-fluid" style="max-width:100%;">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th></th>
						<th>Subject</th>
						<th>Mesasge</th>
						<th>Last Updated Time</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody id="content_table">


				</tbody>
			</table>
			</div>
		</div>
		
	</div>
</div>
<div id="re">

</div>
<div id="wait">

</div>
{!! Form::open() !!}

<!--input type="text" name="task" value="">
	<input type="submit"-->
	{!! Form::close() !!}
	@stop
	@section('footer')
	@stop