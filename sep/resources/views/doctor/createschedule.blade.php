@extends('template/template_user')
	
@section('head')

  <script type="text/javascript">

    function NavigateTo(theUrl)
    {
      document.location.href = theUrl;
    }

    function validateForm() 
    {
      var ScheduleCreated = "<?php echo $created; ?>";
      var monday_from = document.getElementById("monday_from").value;
      var monday_till = document.getElementById("monday_till").value;
      var tuesday_from = document.getElementById("tuesday_from").value;
      var tuesday_till = document.getElementById("tuesday_till").value;
      var wednesday_from = document.getElementById("wednesday_from").value;
      var wednesday_till = document.getElementById("wednesday_till").value;
      var thursday_from = document.getElementById("thursday_from").value;
      var thursday_till = document.getElementById("thursday_till").value;
      var friday_from = document.getElementById("friday_from").value;
      var friday_till = document.getElementById("friday_till").value;
      var saturday_from = document.getElementById("saturday_from").value;
      var saturday_till = document.getElementById("saturday_till").value;
      var sunday_from = document.getElementById("sunday_from").value;
      var sunday_till = document.getElementById("sunday_till").value;

      var test = "23.59";

      var pattern = /^[0-2][0-9][.][0-5][0-9]$/g;

      if(ScheduleCreated == 1)
      {
        if((monday_from == "") && (monday_till == "") && (tuesday_from == "") && (tuesday_till == "") && (wednesday_from == "") && (wednesday_till == "") && (thursday_from == "") && (thursday_till == "") && (friday_from == "") && (friday_till == "") && (saturday_from == "") && (saturday_till == "") && (sunday_from == "") && (sunday_till == ""))
        {
          return false;
        }
        else
        {
          if(monday_from != "") {
              if(!monday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(monday_till != "") {
              if(!monday_till.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(tuesday_from != "") {
              if(!tuesday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(tuesday_till != "") {
              if(!tuesday_till.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(wednesday_from != "") {
              if(!wednesday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(wednesday_till != "") {
              if(!wednesday_till.match(pattern))
              {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(thursday_from != "") {
              if(!thursday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(thursday_till != "") {
              if(!thursday_till.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(friday_from != "") {
              if(!friday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(friday_till != "") {
              if(!friday_till.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(saturday_from != "") {
              if(!saturday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(saturday_till != "") {
              if(!saturday_till.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(sunday_from != "") {
              if(!sunday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(sunday_till != "") {
              if(!sunday_till.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           return true;
        }
      }
      else
      {
        if((monday_from == "") || (monday_till == "") || (tuesday_from == "") || (tuesday_till == "") || (wednesday_from == "") || (wednesday_till == "") || (thursday_from == "") || (thursday_till == "") || (friday_from == "") || (friday_till == "") || (saturday_from == "") || (saturday_till == "") || (sunday_from == "") || (sunday_till == ""))
        {
          alert("One or more fields empty. All fields must be filled during first Schedule update.");
          return false;;
        }
        else
        {
           if(monday_from != "") {
              if(!monday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(monday_till != "") {
              if(!monday_till.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(tuesday_from != "") {
              if(!tuesday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(tuesday_till != "") {
              if(!tuesday_till.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(wednesday_from != "") {
              if(!wednesday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(wednesday_till != "") {
              if(!wednesday_till.match(pattern))
              {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(thursday_from != "") {
              if(!thursday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(thursday_till != "") {
              if(!thursday_till.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(friday_from != "") {
              if(!friday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(friday_till != "") {
              if(!friday_till.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(saturday_from != "") {
              if(!saturday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(saturday_till != "") {
              if(!saturday_till.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(sunday_from != "") {
              if(!sunday_from.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           if(sunday_till != "") {
              if(!sunday_till.match(pattern)) {
                alert("Invalid time format. Correct format is : hh.mm");
                return false;
              }
           }

           return true;
        }
      }

      

    }

</script>

@stop

@section('navbar')
@stop
	
		
@section('body')


<div class="panel-body1">
        <div  class="panel-footer">
            <h3><span class="semi-bold"> Set Schedule</span></h3>
        </div>
        <div class="tab-content">
                        <div class="tab-pane active" id="horizontal-form">
                             {!! Form::open(array('class' => 'form-horizontal', 'files' => true, 'name' => 'editForm', 'onsubmit' => 'return validateForm()')) !!} 
                             <div class="col-lg-12">
                             	<div class="col-xs-2">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Monday</label>
          
                                </div>
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('monday_from', null,  [ 'class' => 'form-control1','id' => 'monday_from', 'placeholder' => 'From']) !!}
                                    </div>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('monday_till', null,  [ 'class' => 'form-control1','id' => 'monday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                </div>    
                              </div>

                              <div class="col-lg-12">
                              <div class="col-xs-2">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Tuesday</label>
          
                                </div>
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('tuesday_from', null,  [ 'class' => 'form-control1','id' => 'tuesday_from', 'placeholder' => 'From']) !!}
                                    </div>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('tuesday_till', null,  [ 'class' => 'form-control1','id' => 'tuesday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                </div>    
                              </div>

                              <div class="col-lg-12">
                              <div class="col-xs-2">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Wednesday</label>
          
                                </div>
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('wednesday_from', null,  [ 'class' => 'form-control1','id' => 'wednesday_from', 'placeholder' => 'From']) !!}
                                    </div>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('wednesday_till', null,  [ 'class' => 'form-control1','id' => 'wednesday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                </div>    
                              </div>

                              <div class="col-lg-12">
                              <div class="col-xs-2">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Thursday</label>
          
                                </div>
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('thursday_from', null,  [ 'class' => 'form-control1','id' => 'thursday_from', 'placeholder' => 'From']) !!}
                                    </div>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('thursday_till', null,  [ 'class' => 'form-control1','id' => 'thursday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                </div>    
                              </div>

                              <div class="col-lg-12">
                              <div class="col-xs-2">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Friday</label>
          
                                </div>
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('friday_from', null,  [ 'class' => 'form-control1','id' => 'friday_from', 'placeholder' => 'From']) !!}
                                    </div>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('friday_till', null,  [ 'class' => 'form-control1','id' => 'friday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                </div>    
                              </div>

                              <div class="col-lg-12">
                              <div class="col-xs-2">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Saturday</label>
          
                                </div>
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('saturday_from', null,  [ 'class' => 'form-control1','id' => 'saturday_from', 'placeholder' => 'From']) !!}
                                    </div>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('saturday_till', null,  [ 'class' => 'form-control1','id' => 'saturday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                </div>    
                              </div>

                              <div class="col-lg-12">
                              <div class="col-xs-2">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Sunday</label>
          
                                </div>
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('sunday_from', null,  [ 'class' => 'form-control1','id' => 'sunday_from', 'placeholder' => 'From']) !!}
                                    </div>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('sunday_till', null,  [ 'class' => 'form-control1','id' => 'sunday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                </div>    
                              </div>
                                
                        </div>
                        <div class="panel-footer">
	                      <div class="row">
	                          <div class="col-sm-8">
	                               {!! Form::submit('Set Schedule', ['class' => 'btn btn_5 btn-lg btn-info']) !!}  
	                               <input class="btn btn_5 btn-lg btn-info" value="Back" onclick="NavigateTo('../profile)">
	                              {!! Form::close() !!}
	                          </div>
	                      </div>
                    	</div>
        </div>
</div>


        
    
@stop

@section('footer')
@stop