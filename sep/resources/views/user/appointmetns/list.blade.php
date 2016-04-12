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
		max-width: 0;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	.control-label{
		font-size: 20px;
	}
</style>

<script type="text/javascript">
const token = "{{ csrf_token() }}";
var showing_table = 1;
var loadtableconfirmed_count=0;
var loadtableunconfirmed_count=0;
var loadtablecanceled_count=0;
var loadtablecompleted_count=0;
var loadtableall_count=0;
/****************************** send json requets to the server ******************************/
	function jsend(dataString){
		$('#wait').show();
		var datas;
		$.ajax({
			type:"POST",
			url : "{{ url('/') }}/view-appointment",
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
			
			var d = {"_token": token ,"task": "loadtableconfirmed","skip":loadtableconfirmed_count};

			jsend(d);
			
			
		}else if(type=="2"){

			var d = {"_token": token ,"task": "loadtableunconfirmed","skip":loadtableunconfirmed_count};

			jsend(d);

		}else if(type=="3"){
			var d = {"_token": token ,"task": "loadtablecanceled","skip":loadtablecanceled_count};

			jsend(d);
		}else if(type=="4"){
			var d = {"_token": token ,"task": "loadtablecompleted","skip":loadtablecompleted_count};

			jsend(d);
		}else if(type=="5"){
			var d = {"_token": token ,"task": "loadtableall","skip":loadtableall_count};
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
		if(data['task']=="loadtableconfirmed"){
			var schedules = data['schedules'];
			var tot = "Showing Confirmed Appointments "+(data['skips']*(loadtableconfirmed_count+1))+" of "+data['total'];
			var doctorName = data['doctorName'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(loadtableconfirmed_count+1)>=totals){
				tot = "Showing Confirmed Appointments "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			} 

			if(loadtableconfirmed_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			}
			$('.showtotal').html(tot);
			for(var i = 0; i < schedules.length; i++){
				htmls+="<tr>";
				htmls+="<td style='width:5%;'><input type='checkbox' id='selectall' value='"+ schedules[i]['id'] +"' class='checkbox inside'></td>";
				htmls+=" <td style='width:30%;'><a href='{{url('/')}}/doctors/"+ doctorName[i]['id'] +"'>"+ doctorName[i]['first_name']+ " " + doctorName[i]['last_name'] +"</a></td>";
				htmls+="<td style='width:30%;'>"+ schedules[i]['schedule_start'] +"</td>";
				htmls+="<td style='width:10%;''><a class='view_appointment_anchor' href='"+ schedules[i]['id'] +"'>View</a></td></tr>";

			}
			showing_table = 1;
			document.getElementById("content_table").innerHTML=htmls;

		}else if(data['task']=="loadtableunconfirmed"){
			var schedules = data['schedules'];
			var tot = "Showing Unconfirmed Appointments "+(data['skips']*(loadtableunconfirmed_count+1))+" of "+data['total'];
			var doctorName = data['doctorName'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(loadtableunconfirmed_count+1)>=totals){
				tot = "Showing Unconfirmed Appointments "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			} 

			if(loadtableunconfirmed_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			}
			$('.showtotal').html(tot);
			for(var i = 0; i < schedules.length; i++){
				htmls+="<tr>";
				htmls+="<td style='width:5%;'><input type='checkbox' id='selectall' value='"+ schedules[i]['id'] +"' class='checkbox inside'></td>";
				htmls+=" <td style='width:30%;'><a href='{{url('/')}}/doctors/"+ doctorName[i]['id'] +"'>"+ doctorName[i]['first_name']+ " " + doctorName[i]['last_name'] +"</a></td>";
				htmls+="<td style='width:30%;'>"+ schedules[i]['schedule_start'] +"</td>";
				htmls+="<td style='width:10%;''><a class='view_appointment_anchor' href='"+ schedules[i]['id'] +"'>View</a></td></tr>";

			}
			showing_table = 2;
			document.getElementById("content_table").innerHTML=htmls;

		}else if(data['task']=="loadtablecanceled"){
			var schedules = data['schedules'];
			var tot = "Showing Canceled Appointments "+(data['skips']*(loadtablecanceled_count+1))+" of "+data['total'];
			var doctorName = data['doctorName'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(loadtablecanceled_count+1)>=totals){
				tot = "Showing Canceled Appointments "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			} 

			if(loadtablecanceled_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			}
			$('.showtotal').html(tot);
			for(var i = 0; i < schedules.length; i++){
				htmls+="<tr>";
				htmls+="<td style='width:5%;'><input type='checkbox' id='selectall' value='"+ schedules[i]['id'] +"' class='checkbox inside'></td>";
				htmls+=" <td style='width:30%;'><a href='{{url('/')}}/doctors/"+ doctorName[i]['id'] +"'>"+ doctorName[i]['first_name']+ " " + doctorName[i]['last_name'] +"</a></td>";
				htmls+="<td style='width:30%;'>"+ schedules[i]['schedule_start'] +"</td>";
				htmls+="<td style='width:10%;''><a class='view_appointment_anchor' href='"+ schedules[i]['id'] +"'>View</a></td></tr>";

			}
			showing_table = 3;
			document.getElementById("content_table").innerHTML=htmls;

		}else if(data['task']=="loadtablecompleted"){
			var schedules = data['schedules'];
			var tot = "Showing Completed Appointments "+(data['skips']*(loadtablecompleted_count+1))+" of "+data['total'];
			var doctorName = data['doctorName'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(loadtablecompleted_count+1)>=totals){
				tot = "Showing Completed Appointments "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			} 

			if(loadtablecompleted_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			}
			$('.showtotal').html(tot);
			for(var i = 0; i < schedules.length; i++){
				htmls+="<tr>";
				htmls+="<td style='width:5%;'><input type='checkbox' id='selectall' value='"+ schedules[i]['id'] +"' class='checkbox inside'></td>";
				htmls+=" <td style='width:30%;'><a href='{{url('/')}}/doctors/"+ doctorName[i]['id'] +"'>"+ doctorName[i]['first_name']+ " " + doctorName[i]['last_name'] +"</a></td>";
				htmls+="<td style='width:30%;'>"+ schedules[i]['schedule_start'] +"</td>";
				htmls+="<td style='width:10%;''><a class='view_appointment_anchor' href='"+ schedules[i]['id'] +"'>View</a></td></tr>";

			}
			showing_table = 4;
			document.getElementById("content_table").innerHTML=htmls;

		}else if(data['task']=="loadtableall"){
			var schedules = data['schedules'];
			var tot = "Showing All Appointments "+(data['skips']*(loadtableall_count+1))+" of "+data['total'];
			var doctorName = data['doctorName'];
			var totals=data['total'];
			var skips=data['skips'];
			if(skips*(loadtableall_count+1)>=totals){
				tot = "Showing All Appointments "+data['total']+" of "+data['total'];
				//hide the next button
				document.getElementById('buttton_next').style.visibility = 'hidden';
			}else{
				document.getElementById('buttton_next').style.visibility = 'visible';
			} 

			if(loadtableall_count==0){
				//hide previous button
				document.getElementById('buttton_previous').style.visibility = 'hidden';
			}else{
				//show both of the buttons
				document.getElementById('buttton_previous').style.visibility = 'visible';
			}
			$('.showtotal').html(tot);
			for(var i = 0; i < schedules.length; i++){
				htmls+="<tr>";
				htmls+="<td style='width:5%;'><input type='checkbox' id='selectall' value='"+ schedules[i]['id'] +"' class='checkbox inside'></td>";
				htmls+=" <td style='width:30%;'><a href='{{url('/')}}/doctors/"+ doctorName[i]['id'] +"'>"+ doctorName[i]['first_name']+ " " + doctorName[i]['last_name'] +"</a></td>";
				htmls+="<td style='width:30%;'>"+ schedules[i]['schedule_start'] +"</td>";
				htmls+="<td style='width:10%;''><a class='view_appointment_anchor' href='"+ schedules[i]['id'] +"'>View</a></td></tr>";

			}
			showing_table = 5;
			document.getElementById("content_table").innerHTML=htmls;
		}else if(data['task']=="viewDetails"){
			var schedules = data['schedules'];
			var doctor = data['doctor'];
			$('#AppointmentDate').html("Schedule Date Time: "+data['startDate']);
			$('#modalPlace').html("Address: "+doctor['address']);
			$('#modalDoctorName').html("Name: "+doctor['first_name']+" "+doctor['last_name']);
			$('#modalDoctorSpec').html("Specialization: "+doctor['specialization']);
			$('#modalDoctorPhone').html("Phone: "+doctor['phone']);
			$('#modalSessionCode').html("Session Code: "+schedules['code']);
			$('#modalcancelAppointment').attr('value',schedules['id']);
			$('#modalStatus').html("Status : "+data['status']);
			if(schedules['cancelUser']==1 || schedules['cancelDoctor']==1){
				$('#modalcancelAppointment').hide();
			}else{
				$('#modalcancelAppointment').show();
			}
			$("#myModal").modal();
		}else if(data['task']=="cancelAppointment"){
			$("#myModal").modal("hide");
			loadtable(showing_table);
			Lobibox.notify("success", {
				title: 'Completed',
				msg: 'Appointment Canceled!',
				sound: '../resources/common/sounds/sound2'
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
		$('.refresh_button').click(function(){
			
				loadtable(showing_table);
			
		});
		$('#dropdown_menu_confirmed').click(function(e){
			if(showing_table!=1){
				loadtable("1");
			}
			e.preventDefault();
		});
		$('#dropdown_menu_unconfirmed').click(function(e){
			if(showing_table!=2){
				loadtable("2");
			}
			e.preventDefault();
		});
		$('#dropdown_menu_cancel').click(function(e){
			if(showing_table!=3){
				loadtable("3");
			}
			e.preventDefault();
		});
		$('#dropdown_menu_completed').click(function(e){
			if(showing_table!=4){
				loadtable("4");
			}
			e.preventDefault();
		});
		$('#dropdown_menu_all').click(function(e){
			if(showing_table!=5){
				loadtable("5");
			}
			e.preventDefault();
		});
		$('#content_table').on('click','.view_appointment_anchor',function(e){
			//alert($(this).attr('href'));
			e.preventDefault();
			var ids=[];
			ids[0] = $(this).attr('href');
			var requets = {"_token": token ,"task": "viewDetails","appointment":ids};
			jsend(requets);
		});
		$('#modalcancelAppointment').click(function(e){
			e.preventDefault();
			var ids=[];
			ids[0] = $(this).attr('value');
			//alert(ids[0]);
			Lobibox.confirm({
    			msg: "Are you sure you want to cancel the appointment?",
    			callback: function ($this, type, ev) {
        			if (type === 'no'){
	    				return false;
	    			}else{
	    				var requets = {"_token": token ,"task": "cancelAppointment","appointments":ids};
						jsend(requets);
	    			}
    			}
			});
		});
		$('#buttton_previous').click(function(e){
			if(showing_table==1){
				loadtableconfirmed_count--;
				
				loadtable("1");

			}else if(showing_table==2){
				loadtableunconfirmed_count--;
				loadtable("2");
			}else if(showing_table==3){
				loadtablecanceled_count--;
				loadtable("3");
			}else if(showing_table==4){
				loadtablecompleted_count--;
				loadtable("4");
			}else{
				loadtableall_count--;
				loadtable("5");
			}

		});
		
		$('#buttton_next').click(function(e){
			if(showing_table==1){
				loadtableconfirmed_count++;
				
				loadtable("1");

			}else if(showing_table==2){
				loadtableunconfirmed_count++;
				loadtable("2");
			}else if(showing_table==3){
				loadtablecanceled_count++;
				loadtable("3");
			}else if(showing_table==4){
				loadtablecompleted_count++;
				loadtable("4");
			}else{
				loadtableall_count++;
				loadtable("5");
			}

		});

	});
</script>
@stop
@section('navbar')
@stop
@section('body')
<div class="row">
	<div class="container-fluid">
		<div class="col-sm-8">

		</div>
		<div class="col-sm-4">
			<div class="input-group" style="border-radius:0px !important;">
				<input type="text" class="form-control" placeholder="&#xf002;" style="font-family: 'FontAwesome';border-radius:0px !important;">
				
			</div>
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

						<!--div id="dbox" class="dropdown" style="float:left;padding:0px;padding-top:10px;">

							<a href="#" style="padding:10px;margin:0px;border:0px solid black;padding-bottom:5px;padding-top:8px;color:black;" data-toggle="dropdown"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
								<span class="caret"></span>
							</a>

							<ul class="dropdown-menu">
								<li id="action_close_ticket"><a href="#">Cancel</a></li>
								<li id="action_open_ticket"><a href="#">Open</a></li>
								
							</ul>
						</div-->







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
								<li><a id="dropdown_menu_confirmed" href="#">Confirmed</a></li>
								<li><a id="dropdown_menu_unconfirmed" href="#">Unconfirmed</a></li>
								<li><a id="dropdown_menu_cancel" href="#">Canceled</a></li>
								<li><a id="dropdown_menu_completed" href="#">Completed</a></li>
								<li><a id="dropdown_menu_all" href="#">All</a></li>
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
						<th>Doctor Name</th>
						<th>schedule</th>
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


<div id="wait"></div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="AppointmentDate">Modal Header</h4>
      </div>
      <div class="modal-body">
        <label id="modalPlace" class="control-label">Address:</label><br>
        <label id="modalStatus" class="control-label">Session Code:</label><br>
        <label id="modalDoctorName" class="control-label">Doctor Name:</label><br>
        <label id="modalDoctorSpec" class="control-label">Doctor Specialization:</label><br>
        <label id="modalDoctorPhone" class="control-label">Phone Number:</label><br>
        <label id="modalSessionCode" class="control-label">Session Code:</label><br>
      </div>
      <div class="modal-footer">
        <button type="button" value="" id="modalcancelAppointment" class="btn btn-danger">Cancel Appointment</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@stop
@section('footer')
@stop