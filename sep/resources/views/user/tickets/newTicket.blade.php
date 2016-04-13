@extends('template/template_user')

@section('head')

<style type="text/css">

</style>
<script type="text/javascript">
	$(document).ready(function(){
		$('[name=heading]').prop('disabled', true);
		$('[name=headingbanner]').css('visibility', 'hidden');
		$('[name=heading]').css('visibility', 'hidden');

		$('[name=options]').click(function(){
			if($(this).val()=="custom"){
				$('[name=heading]').prop('disabled', false);
				$('[name=heading]').css('visibility', 'visible');
				$('[name=headingbanner]').css('visibility', 'visible');
			}else{
				$('[name=heading]').prop('disabled', true);
				$('[name=heading]').css('visibility', 'hidden');
				$('[name=headingbanner]').css('visibility', 'hidden');
			}
		});

		$('#submitTicket').submit(function(e){
			
			//e.unbind();
			var text = document.getElementById("txtarea1").value;
			text = text.trim();
			//document.getElementById("replyText").value="";
			if(text==""){
				e.preventDefault();
				Lobibox.notify("warning", {
					title: 'warning',
					msg: "You havent typed anything",
					sound: '../resources/common/sounds/sound4'
				});
				return false;
			}
			if($('[name=options]').val()=="custom"){
				var text = document.getElementById("smallinput").value;
				text = text.trim();
				//document.getElementById("replyText").value="";
				if(text==""){
					e.preventDefault();
					Lobibox.notify("warning", {
						title: 'warning',
						msg: "You havent typed anything in heading",
						sound: '../resources/common/sounds/sound4'
					});
					return false;
				}
			}

		});

	});
</script>
@stop

@section('navbar')
@stop


@section('body')

<div class="row">
	
	<div class="col-md-12">
		<div class="r3_counter_box">
@if(empty($created) || $created == 0)			


			<div class="tab-pane active" id="horizontal-form">

				{!! Form::open(['class'=>'form-horizontal','id'=>'submitTicket']) !!}


				<div class="form-group">
					<label for="disabledinput" class="col-sm-2 control-label" >Email</label>
					<div class="col-sm-8">
						<input disabled="" type="text" name="email" class="form-control1" id="disabledinput" value="{{ $user->email }}" placeholder="Disabled Input">
					</div>
				</div>
				<div class="form-group">
					<label for="selector1" class="col-sm-2 control-label">Subject</label>
					<div class="col-sm-8">
					<select name="options" id="selector1" class="form-control1">
						<option value="Problem 1">Problem 1</option>
						<option value="Problem 2">Problem 2</option>
						<option value="Problem 3">Problem 3</option>
						<option value="custom">Custom</option>
					</select>
					</div>
				</div>
				<div class="form-group">
					<label for="smallinput" name="headingbanner" class="col-sm-2 control-label label-input-sm">Heading</label>
					<div class="col-sm-8">
						<input type="text" class="form-control1 input-sm" id="smallinput" placeholder="Type Heading in here" name="heading">
					</div>
				</div>
				<div class="form-group">
					<label for="txtarea1" class="col-sm-2 control-label">Message</label>
					<div class="col-sm-8"><textarea name="txtarea" id="txtarea1" cols="50" rows="15" class="form-control1" style="height:200px;"></textarea></div>
				</div>
				<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						
					{!! Form::submit('Submit', array('class' => 'btn-default btn')) !!}
						<input type="reset" class="btn-inverse btn" value="Reset">
					</div>
				</div>
			</div>





			{!! Form::close() !!}

		</div>

@else
	<div class="container-fluid">
		<h1>Ticket Created Successfull</h1>
	</div>
@endif

	</div> 
</div>

</div>
@stop
@section('footer')
@stop