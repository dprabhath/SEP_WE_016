@extends('admintemplate/template_admin')

@section('head')
<style type="text/css">
	.reply-user{
		border-radius: 12px 12px 12px 12px;
		-moz-border-radius: 12px 12px 12px 12px;
		-webkit-border-radius: 12px 12px 12px 12px;
		border: 0px solid #000000;
		background-color: #93e374;
		color: black !important;
		-webkit-box-shadow: 0px 0px 9px 2px rgba(65,168,93,1);
		-moz-box-shadow: 0px 0px 9px 2px rgba(65,168,93,1);
		box-shadow: 0px 0px 9px 2px rgba(65,168,93,1);
	}
	.reply-staff{
		border-radius: 12px 12px 12px 12px;
		-moz-border-radius: 12px 12px 12px 12px;
		-webkit-border-radius: 12px 12px 12px 12px;
		border: 0px solid #000000;
		background-color: #fcd86d;
		color: black !important;
		-webkit-box-shadow: 0px 0px 9px 2px rgba(177,181,70,1);
		-moz-box-shadow: 0px 0px 9px 2px rgba(177,181,70,1);
		box-shadow: 0px 0px 9px 2px rgba(177,181,70,1);
	}
	p{
		color: black !important;
	}
</style>

<script type="text/javascript">
	const token = "{{ csrf_token() }}";
	const ticket_id = {{ $ticket->id }};
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
		if(data['task']=="replyTickets"){

			Lobibox.notify("success", {
				title: 'success',
				msg: "Reply Sent",
				sound: '../../resources/common/sounds/sound2'
			});
			//document.getElementById("content_table").innerHTML=htmls;
			var M = data['msg'];
			var htmlMsg = "";
			htmlMsg+= "<div style='padding:10px;'>";
			htmlMsg+= "<div class='media reply-user' style='padding:10px;'>";
			htmlMsg+= "<div class='media-left'>";
			htmlMsg+= "<a href='#'>";
			@if(! empty($user) && $user->pic!='')


			htmlMsg+="<img height='48' width='48' class='media-object img-circle' src='{{ url('/') }}/{{$user->pic}}' alt='...'>";
			@else

			htmlMsg+="<img height='48' width='48' class='media-object img-circle' src={{ url('/') }}/uploads/profile_pics/emp.png alt='...'>";
			@endif
			
			htmlMsg+= "</a></div>";
			htmlMsg+= "<div class='media-body'>";
			htmlMsg+= "<p> "+M['message']+" </p>";
			htmlMsg+= "<p style='padding-top:20px;'>Time "+M['created_at']+" </p></div></div></div>";

			document.getElementById('messageWindow').innerHTML+=htmlMsg;
			var objDiv = document.getElementById('messageWindow');
			objDiv.scrollTop = objDiv.scrollHeight;



		}

	}


	$(document).ready(function(){
		var objDiv = document.getElementById('messageWindow');
		objDiv.scrollTop = objDiv.scrollHeight;

		$('#reply_form').submit(function(e){
			e.preventDefault();
			//e.unbind();
			var text = document.getElementById("replyText").value;
			text = text.trim();
			document.getElementById("replyText").value="";
			if(text==""){
				Lobibox.notify("warning", {
					title: 'warning',
					msg: "You havent typed anything",
					sound: '../../resources/common/sounds/sound4'
				});
				return false;
			}
			var requets = {"_token": token ,"task": "replyTickets","text":text,"ticket_id":ticket_id};
			jsend(requets);



		});


	});

</script>
@stop


@section('navigation')

@stop

@section('body')
<div class="container-fluid" style="background:#fff;padding-top:10px;">
	<div class="row">
		<div class="col-xs-12">
			<address>
				<strong>{{ $ticket->subject }}</strong><br>

				@if($ticket->opened==1)
				<abbr title="Phone">Status:</abbr> Opend <br>
				@else
				<abbr title="Phone">Status:</abbr> Closed <br>
				@endif

				<abbr title="User">UserName: </abbr><a target='_blank' href="{{ url('/') }}/user/{{$ticket_owner->id}}" >{{$ticket_owner->email}}</a><br>
				<abbr title="Phone">Opend Date:</abbr> {{ $ticket->created_at }} <br>
				<?php

				?>
				<?php $item = count($messages); ?>

				<abbr title="Phone">Last Updated Date:</abbr> {{$messages[$item-1]->created_at}}
			</address>
		</div>
	</div>
	<div id="messageWindow" class="row" style="overflow-y:scroll; height:70vh;padding:10px;background-color: #d5dade;">

		@foreach ($messages as $message)

		@if( $message->user_id == $ticket_owner->id )

		<div style="padding:10px;">
			<div class="media reply-staff" style="padding:10px;">
				<div class="media-right pull-right">
					<a href="#">
						<img height="48" width="48" class="media-object img-circle"
						@if(! empty($ticket_owner) && $ticket_owner->pic!='')

						src="{{ url('/') }}/{{$ticket_owner->pic}}"

						@else
						src="{{ url('/') }}/uploads/profile_pics/emp.png"
						@endif
						alt="...">
					</a>
				</div>
				<div class="media-body">
					
					<p> {{$message->message}} </p>
					<p style="padding-top:20px;">Time {{$message->created_at}} </p>
				</div>
			</div>
		</div>


		@else

		<div style="padding:10px;">
			<div class="media reply-user" style="padding:10px;">
				<div class="media-left">
					<a href="#">
						@if(! empty($user) && $user->pic!='')

						<img height="48" width="48" class="media-object img-circle" src="{{ url('/') }}/{{$user->pic}}" alt="...">

						@else
						<img height="48" width="48" class="media-object img-circle" src="{{ url('/') }}/uploads/profile_pics/emp.png" alt="...">
						@endif

					</a>
				</div>
				<div class="media-body">
					
					<p> {{$message->message}} </p>
					<p style="padding-top:20px;">Time {{$message->created_at}} </p>
				</div>
			</div>
		</div>

		@endif




		@endforeach

	</div>
	@if($ticket->opened==1)
	<div class="row" style="padding:20px;">
		<form id="reply_form">
			<div class="form-group">
				<label for="exampleInputEmail1">Reply:</label>
				<textarea id="replyText" class="form-control" rows="4" style="border:1px solid black !important;border-radius:0px !important;background-color:rgba(0,0,0,0.1) !important;"></textarea>
			</div>
			<button type="submit" class="btn btn-default">Reply</button>
			<button type="reset" class="btn btn-default">Reset</button>
		</form>
	</div>
	@else
	<div class="row" style="padding:50px;">

	</div>
	@endif
</div>

<div id="wait">

</div>
@stop