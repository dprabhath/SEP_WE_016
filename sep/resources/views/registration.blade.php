@extends('template/template_user')

@section('head')

<style type="text/css">

	
	#wait{

		display:    none;
		position:   fixed;
		z-index:    10000000;
		top:        0;
		left:       0;
		height:     100%;
		width:      100%;
		background: rgba( 255, 255, 255, .8 ) 
		url('resources/common/gif/ajax-loader.gif') 
		50% 50% 
		no-repeat;
	}
	.form-control{
		border:1px black solid !important;
		border-radius:3px !important;
	}
	.control-label{
		font-weight: bold !important;
		color: black !important;
	}
</style>
<script type="text/javascript">
const token = "{{ csrf_token() }}";
	/*************************REGEX Checks*******************************/

	function isEmail(email) {
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}
	function isPhone(phone){
		var regex = /^[0-9]{9}$/;
		return regex.test(phone);
	}
	function isNIC(nic){
		var regex = /^[0-9]{9}[v]{1}$/;
		return regex.test(nic);
	}
	/**************************jquery post*******************************/
	function jsend(dataString){
   // $('#wait').show();
    var datas;
    $.ajax({
      type:"POST",
      url : "{{ url('/') }}/register",
      data:dataString,
      success : function(data){
        //document.getElementById("re").innerHTML=data['code']; 
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
  function returnofjsend(data){
    var htmls="";
    //$('#wait').hide();
    
    if(data['task']=="checkEmail"){

      if(data['code']=="error"){
        $("#txtEmailDiv").attr('class', 'form-group has-error has-feedback');
        $("#txtEmailFeed").attr('class', 'glyphicon glyphicon-remove form-control-feedback');
        $("#txtEmailErro").text(data['message']);

      }else{
         $("#txtEmailDiv").attr('class', 'form-group has-success has-feedback');
         $("#txtEmailFeed").attr('class', 'glyphicon glyphicon-ok form-control-feedback');
         $("#txtEmailErro").text("");
      }
      

    }else if(data['task']=="loadtableclosedtickets"){
      
    }

  }

  $(document).ready(function(){
    $("#txtEmail").focusout(function(){
      
      if(isEmail($(this).val()))
      {
        
        $("#txtEmailErro").text("");

        var d = {"_token": token ,"task": "checkEmail" ,"email": $(this).val()};
        jsend(d);

      }else{
       
        //$("#txtEmailErro").text("Invlaid Email");
        $("#txtEmailDiv").attr('class', 'form-group has-error has-feedback');
        $("#txtEmailFeed").attr('class', 'glyphicon glyphicon-remove form-control-feedback');

      }

    });

    $("#txtPasswordRe").focusout(function(){

      

    });


  });
</script>
@stop

@section('navbar')
@stop


@section('body')


<div class="row">
<div class="r3_counter_box">
{!! Form::open(['id' => 'registration','class' => 'form-horizontal','style' => 'padding-top:20px;']) !!}

  <div id="txtEmailDiv" class="form-group has-success has-feedback">
    <label class="control-label col-sm-3" for="txtEmail">Email</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="txtEmail" name="txtEmail" aria-describedby="inputSuccess3Status">
      <span class="glyphicon glyphicon-ok form-control-feedback" id="txtEmailFeed" aria-hidden="true"></span>
      <span id="txtEmailErro" style="color:red;"></span>
    </div>
  </div>
  
  <div id="txtPasswordDiv" class="form-group has-success has-feedback">
    <label class="control-label col-sm-3" for="txtPassword">Password</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="txtPassword" name="txtPassword" aria-describedby="inputSuccess3Status">
      <span class="glyphicon glyphicon-ok form-control-feedback" id="txtPasswordFeed" aria-hidden="true"></span>
       <span id="txtPasswordErro"></span>
    </div>
  </div>

  <div class="form-group has-success has-feedback">
    <label class="control-label col-sm-3" for="txtPasswordRe">Retype Password</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="txtPasswordRe" aria-describedby="inputSuccess3Status">
      
      
    </div>
  </div>

    <div class="form-group has-success has-feedback">
    	<label class="control-label col-sm-3" for="txtPhone">Phone Number</label>
    	<div class="col-sm-7">
        <div class="input-group">
        <span class="input-group-addon">+94</span>
      	<input type="text" class="form-control" id="txtPhone" name="txtPhone" aria-describedby="inputSuccess3Status">
        </div>
      	<span class="glyphicon glyphicon-ok form-control-feedback" id="txtPhoneFeed" aria-hidden="true"></span>
        
        <span id="txtPhoneErro">asd</span>
    </div>
  	</div>

  	  <div class="form-group has-success has-feedback">
    <label class="control-label col-sm-3" for="txtNIC">NIC</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="txtNIC" name="txtNIC" aria-describedby="inputSuccess3Status">
      <span class="glyphicon glyphicon-ok form-control-feedback" id="txtNICFeed" aria-hidden="true"></span>
      <span id="txtNICErro"></span>
    </div>
    </div>
 


  <div class="form-group has-success has-feedback">
    <label class="control-label col-sm-3" for="inputSuccess3"></label>
    <div class="col-sm-7">
      
     {!! Form::captcha() !!}
    </div>
  </div>

  <div class="form-group has-success has-feedback">
    <label class="control-label col-sm-3" for="inputSuccess3"></label>
    <div class="col-sm-7">
      
     <button type="submit" class="btn btn-default">Submit</button>
     <button type="reset" class="btn btn-default">Reset</button>
    </div>
  </div>
  
{!! Form::close() !!}


</div>
<div id="wait">

</div>
{!! Captcha::script() !!}
@stop
@section('footer')
@stop