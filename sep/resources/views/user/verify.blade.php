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
  var currentEmail = "{{$user->email}}";
  var currentPhone = "{{$phone}}";
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
 function jsendNew(dataString){
  $('#wait').show();
  var datas;
  $.ajax({
    type:"POST",
    url : "{{ url('/') }}/verify",
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
  $('#wait').hide();
  
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
 }else if(data['task']=="sendEmail"){
  if(data['code']=="error"){
    Lobibox.notify("error", {
      title: 'Erro',
      msg: data['message'],
      sound: '../resources/common/sounds/sound4'
    }); 
  }else{
    currentEmail = data['email'];
    Lobibox.notify("success", {
      title: 'success',
      msg: 'email sent',
      sound: '../resources/common/sounds/sound2'
    });
  }
}else if(data['task']=="sendPhone"){
 if(data['code']=="error"){
  Lobibox.notify("error", {
    title: 'Erro',
    msg: data['message'],
    sound: '../resources/common/sounds/sound4'
  }); 
}else{
  currentPhone = data['phone'].replace("+94","");
  Lobibox.notify("success", {
    title: 'success',
    msg: 'MMS sent',
    sound: '../resources/common/sounds/sound2'
  });
}
}else if(data['task']=="verify"){
 if(data['code']=="error"){
  Lobibox.notify("error", {
    title: 'Erro',
    msg: data['message'],
    sound: '../resources/common/sounds/sound4'
  }); 
}else{
  Lobibox.notify("success", {
    title: 'success',
    msg: 'successfully Activated',
    sound: '../resources/common/sounds/sound2'
  });
  
  setTimeout(
    function() 
    {
      window.location.href="profile";
    }, 3000);
}
}

}

$(document).ready(function(){
  $("#txtEmail").focusout(function(){
    
    if(currentEmail==$(this).val() && isEmail($(this).val())){
       emailVerify=true;
      $("#txtEmailDiv").attr('class', 'form-group has-success has-feedback');
      $("#txtEmailFeed").attr('class', 'glyphicon glyphicon-ok form-control-feedback');
      $("#txtEmailErro").text("");
      return;
    }
    if(isEmail($(this).val()))
    {
      
      $("#txtEmailErro").text("");

      var d = {"_token": token ,"task": "checkEmail" ,"email": $(this).val()};
      jsend(d);

    }else{
     
        //$("#txtEmailErro").text("Invlaid Email");
        $("#txtEmailErro").text("");
        $("#txtEmailDiv").attr('class', 'form-group has-error has-feedback');
        $("#txtEmailFeed").attr('class', 'glyphicon glyphicon-remove form-control-feedback');

      }

    });



  $("#txtPhone").focusout(function(){
    if(currentPhone==($(this).val()) && isPhone($(this).val()) ){
      phoneVerify=true;

     $("#txtPhoneDiv").attr('class', 'form-group has-success has-feedback');
     $("#txtPhoneFeed").attr('class', 'glyphicon glyphicon-ok form-control-feedback');
     $("#txtPhoneErro").text("");
      return;
    }
    if(isPhone($(this).val())){
     $("#txtPhoneErro").text("");

     var d = {"_token": token ,"task": "checkPhone" ,"phone": $(this).val()};
     jsend(d);

   }else{
    $("#txtPhoneErro").text("");
    $("#txtPhoneDiv").attr('class', 'form-group has-error has-feedback');
    $("#txtPhoneFeed").attr('class', 'glyphicon glyphicon-remove form-control-feedback');
  }

});
  
  $("#txtEmailResend").click(function(){
    var d = {"_token": token ,"task": "sendEmail" ,"email": $("#txtEmail").val()};
    jsendNew(d);

  });

  $("#txtPhoneResend").click(function(){
   var d = {"_token": token ,"task": "sendPhone" ,"phone": $("#txtPhone").val()};
   jsendNew(d);
 });

  $("#verifyButton").click(function(){

    if($.trim($("#txtPhoneCode").val())=="" || $.trim($("#txtEmailCode").val())==""){
      Lobibox.notify("warning", {
        title: 'Warning',
        msg: 'Fill the confirmation codes',
        sound: '../resources/common/sounds/sound3'
      });
      return;
    }

    var d = {"_token": token ,"task": "verify" ,"codePhone": $("#txtPhoneCode").val(),"codeEmail": $("#txtEmailCode").val()};
    jsendNew(d);
  });

});
</script>
@stop

@section('navbar')
@stop


@section('body')


<div class="row">
  <div class="r3_counter_box">
    <p style="color:red;padding-top:10px;"></p>
    {!! Form::open(['id' => 'registration','class' => 'form-horizontal','style' => 'padding-top:20px;']) !!}
    <input type="hidden" name="task" value="submit">
    <div id="txtEmailDiv" class="form-group has-feedback">
      <label class="control-label col-sm-2" for="txtEmail">Email</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="txtEmail" name="txtEmail" aria-describedby="inputSuccess3Status" value="{{$user->email}}">
        <span class="glyphicon form-control-feedback" id="txtEmailFeed" aria-hidden="true"></span>
        <span id="txtEmailErro" style="color:red;"></span>
      </div>
      <div class="col-sm-1">
       <button type="button" id="txtEmailResend" class="btn btn-default">Resend</button>
       
     </div>
     <div class="col-sm-2">
      <input type="text" class="form-control" id="txtEmailCode" name="txtEmailCode" aria-describedby="inputSuccess3Status" value="">
      
    </div>
    <div class="col-sm-1">
     
      
    </div>
  </div>
  





  <div id="txtPhoneDiv" class="form-group has-feedback">
    <label class="control-label col-sm-2" for="txtPhone">Phone</label>
    <div class="col-sm-4">
      <div class="input-group">
        <span class="input-group-addon">+94</span>
        <input type="text" class="form-control" id="txtPhone" name="txtPhone" aria-describedby="inputSuccess3Status" value="{{$phone}}">
      </div>
      <span class="glyphicon form-control-feedback" id="txtPhoneFeed" aria-hidden="true"></span>
      <span id="txtPhoneErro" style="color:red;"></span>
    </div>
    <div class="col-sm-1">
     <button type="button" id="txtPhoneResend" class="btn btn-default">Resend</button>
     
   </div>
   <div class="col-sm-2">
    <input type="text" class="form-control" id="txtPhoneCode" name="txtPhoneCode" aria-describedby="inputSuccess3Status" value="">
    
  </div>
  <div class="col-sm-1">
    
    
  </div>
</div>

<div class="form-group has-feedback">
  <label class="control-label col-sm-2" for="txtPhone"></label>
  <div class="col-sm-4">
   
  </div>
  <div class="col-sm-2">
   
    
  </div>
  <div class="col-sm-1">
   <button type="button" id="verifyButton" class="btn btn-default">Verify</button>
   
 </div>
 <div class="col-sm-1">
   
  
 </div>
</div>



{!! Form::close() !!}


</div>
<div id="wait">

</div>

@stop
@section('footer')
@stop