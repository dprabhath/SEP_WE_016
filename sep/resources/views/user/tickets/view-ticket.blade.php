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

	#dbox{
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
</style>

<script type="text/javascript">
	

$(document).ready(function(){
	$('#selectall').click(function(){

			if($(this).prop('checked')==true){
				
				$('.inside').prop('checked', true);
			}else{
				$('.inside').prop('checked', false);
			}

			
			return true;

		});

});

</script>

@stop
@section('navbar')
@stop
@section('body')
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
						<div id="dbox" style="float:left;">
							<span class="glyphicon glyphicon glyphicon-refresh" aria-hidden="true"></span>
						</div>
						<div id="dbox" style="float:left;border-color: #fff;padding:2px;">
						</div>

						<div id="dbox" class="dropdown" style="float:left;padding:0px;padding-top:10px;">

						<a href="#" style="padding:10px;margin:0px;border:0px solid black;padding-bottom:5px;padding-top:8px;color:black;" data-toggle="dropdown"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
								<span class="caret"></span>
							</a>

							<ul class="dropdown-menu">
								<li><a href="#">HTML</a></li>
								<li><a href="#">CSS</a></li>
								<li><a href="#">JavaScript</a></li>
							</ul>
						</div>







						<div id="dbox" style="float:right;font-size: 12px;padding-top:12px;">
							<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
						</div>
						<div id="dbox" style="float:right;font-size: 12px;padding-top:12px;">
							<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
						</div>
						<div id="dbox" style="float:right;border-color: #fff;padding:7px;">
						</div>


						<div id="dbox" class="dropdown" style="float:right;padding:0px;padding-top:10px;">

						<a href="#" style="padding:10px;margin:0px;border:0px solid black;padding-bottom:5px;padding-top:8px;color:black;" data-toggle="dropdown"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
								<span class="caret"></span>
							</a>

							<ul class="dropdown-menu">
								<li><a href="#">HTML</a></li>
								<li><a href="#">CSS</a></li>
								<li><a href="#">JavaScript</a></li>
							</ul>
						</div>

						<div id="dbox" style="float:right;border-color: #fff;padding:7px;">
						</div>
						<div id="dbox" style="float:right;font-size: 12px;padding-top:12px;color:grey;border-color: #fff;">
							Showing 1 of 1
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="container-fluid">
		<table class="table table-hover">
    <thead>
      <tr>
        <th></th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><input type="checkbox" id="selectall" class="checkbox inside"></td>
        <td>Doe</td>
        <td>john@example.com</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td><input type="checkbox" id="selectall" class="checkbox inside"></td>
        <td>Moe</td>
        <td>mary@example.com</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td><input type="checkbox" id="selectall" class="checkbox inside"></td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td>john@example.com</td>
      </tr>
    </tbody>
  </table>
		</div>
		
	</div>
</div>
<div id="re">

</div>
<div id="wait">

</div>
@stop
@section('footer')
@stop