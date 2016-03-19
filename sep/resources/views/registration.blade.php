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
var emailVerify=false;
var phoneVerify=false;
var passwordVerify=false;
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
        $('#wait').hide();
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
        emailVerify=false;
      }else{
          emailVerify=true;
         $("#txtEmailDiv").attr('class', 'form-group has-success has-feedback');
         $("#txtEmailFeed").attr('class', 'glyphicon glyphicon-ok form-control-feedback');
         $("#txtEmailErro").text("");
      }
      

    }else if(data['task']=="checkPhone"){

      if(data['code']=="error"){
        $("#txtPhoneDiv").attr('class', 'form-group has-error has-feedback');
        $("#txtPhoneFeed").attr('class', 'glyphicon glyphicon-remove form-control-feedback');
        $("#txtPhoneErro").text(data['message']);
         
          phoneVerify=false;
      }else{
           phoneVerify=true;
         $("#txtPhoneDiv").attr('class', 'form-group has-success has-feedback');
         $("#txtPhoneFeed").attr('class', 'glyphicon glyphicon-ok form-control-feedback');
         $("#txtPhoneErro").text("");
      }
    }

  }
function passwordCheck(){
  if($.trim($("#txtPasswordRe").val())!="" && $("#txtPasswordRe").val()==$("#txtPassword").val() && $.trim($("#txtPassword").val())!=""){

          $("#txtPasswordErro").text("");
           $("#txtPasswordDiv").attr('class', 'form-group has-success has-feedback');
          $("#txtPasswordFeed").attr('class', 'glyphicon glyphicon-ok form-control-feedback');
          passwordVerify = true;

        }else{
          passwordVerify = false;
          $("#txtPasswordErro").text("Password Missmatch");
          $("#txtPasswordDiv").attr('class', 'form-group has-error has-feedback');
          $("#txtPasswordFeed").attr('class', 'glyphicon glyphicon-remove form-control-feedback');

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
        passwordCheck();


    });
    $("#txtPassword").focusout(function(){
       passwordCheck();


    });

    $("#txtPhone").focusout(function(){
        if(isPhone($(this).val())){
             $("#txtPhoneErro").text("");

              var d = {"_token": token ,"task": "checkPhone" ,"phone": $(this).val()};
              jsend(d);

        }else{
          $("#txtPhoneDiv").attr('class', 'form-group has-error has-feedback');
          $("#txtPhoneFeed").attr('class', 'glyphicon glyphicon-remove form-control-feedback');
        }

    });
    $("#txtNIC").focusout(function(){
        if(isNIC($(this).val())){
           $("#txtNICDiv").attr('class', 'form-group has-success has-feedback');
          $("#txtNICFeed").attr('class', 'glyphicon glyphicon-ok form-control-feedback');
        }else{
          
          if($.trim($(this).val())!=""){
             $("#txtNICDiv").attr('class', 'form-group has-warning has-feedback');
             $("#txtNICFeed").attr('class', 'glyphicon glyphicon-warning-sign form-control-feedback');
          }else{
            $("#txtNICDiv").attr('class', 'form-group has-feedback');
             $("#txtNICFeed").attr('class', 'glyphicon form-control-feedback');
          }
         
        }

    });
    $("#registration").submit(function(e){
        if(!phoneVerify){
          Lobibox.notify("error", {
          title: 'Erro',
          msg: 'Check your phone number',
          sound: '../resources/common/sounds/sound4'
        });
          e.preventDefault();
        }else if(!emailVerify){
          Lobibox.notify("error", {
          title: 'Erro',
          msg: 'Check your Email',
          sound: '../resources/common/sounds/sound4'
        });
          e.preventDefault();
        }else if(!passwordVerify){
          Lobibox.notify("error", {
          title: 'Erro',
          msg: 'Check your password',
          sound: '../resources/common/sounds/sound4'
          });
          e.preventDefault();
        }else if (grecaptcha.getResponse() == "") {
            Lobibox.notify("error", {
              title: 'Erro',
              msg: 'Please fill the captcha!',
              sound: '../resources/common/sounds/sound4'
              });
              
              e.preventDefault();
        }

          
        
    

    });

  });
</script>
@stop

@section('navbar')
@stop


@section('body')


<div class="row">
<div class="r3_counter_box">
<p style="color:red;padding-top:10px;">Things marked as (*) are important</p>
{!! Form::open(['id' => 'registration','class' => 'form-horizontal','style' => 'padding-top:20px;']) !!}
  <input type="hidden" name="task" value="submit">
  <div id="txtEmailDiv" class="form-group has-feedback">
    <label class="control-label col-sm-3" for="txtEmail">Email <span style="color:red;">*</span></label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="txtEmail" name="txtEmail" aria-describedby="inputSuccess3Status" value="{{ isset($email) ? $email:''}}">
      <span class="glyphicon form-control-feedback" id="txtEmailFeed" aria-hidden="true"></span>
      <span id="txtEmailErro" style="color:red;"></span>
    </div>
  </div>
  
  <div id="txtPasswordDiv" class="form-group has-feedback">
    <label class="control-label col-sm-3" for="txtPassword">Password  <span style="color:red;">*</span></label>
    <div class="col-sm-7">
      <input type="password" class="form-control" id="txtPassword" name="txtPassword" aria-describedby="inputSuccess3Status">
      <span class="glyphicon form-control-feedback" id="txtPasswordFeed" aria-hidden="true"></span>
       <span id="txtPasswordErro" style="color:red;"></span>
    </div>
  </div>

  <div class="form-group has-feedback">
    <label class="control-label col-sm-3" for="txtPasswordRe">Retype Password  <span style="color:red;">*</span></label>
    <div class="col-sm-7">
      <input type="password" class="form-control" id="txtPasswordRe" aria-describedby="inputSuccess3Status">
      
      
    </div>
  </div>

    <div id="txtPhoneDiv" class="form-group has-feedback">
    	<label class="control-label col-sm-3" for="txtPhone">Phone Number  <span style="color:red;">*</span></label>
    	<div class="col-sm-7">
        <div class="input-group">
        <span class="input-group-addon">+94</span>
      	<input type="text" class="form-control" id="txtPhone" name="txtPhone" aria-describedby="inputSuccess3Status" value="{{isset($phone) ? $phone:''}}">
        </div>
      	<span class="glyphicon form-control-feedback" id="txtPhoneFeed" aria-hidden="true"></span>
        
        <span id="txtPhoneErro" style="color:red;"></span>
    </div>
  	</div>

  	  <div id="txtNICDiv" class="form-group has-feedback">
    <label class="control-label col-sm-3" for="txtNIC">NIC</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="txtNIC" name="txtNIC" value="{{isset($nic) ? $nic:''}}" aria-describedby="inputSuccess3Status">
      <span class="glyphicon form-control-feedback" id="txtNICFeed" aria-hidden="true"></span>
      <span id="txtNICErro"></span>
    </div>
    </div>
 


  <div class="form-group has-success has-feedback">
    <label class="control-label col-sm-3" for="inputSuccess3"> <span style="color:red;">*</span></label>
    <div class="col-sm-7" id="recaptcha_sme">
      
     {!! Form::captcha() !!}
     <span style="color:red;">{{isset($captcha) ? $captcha:''}}</span>
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