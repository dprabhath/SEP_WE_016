@extends('template/template_user')
	
@section('head')
  
  <script type="text/javascript" src="{{ url('/') }}/resources/common/timepicker/jquery.timepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/resources/common/timepicker/jquery.timepicker.css" />

  <script type="text/javascript" src="{{ url('/') }}/resources/common/timepicker/lib/bootstrap-datepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/resources/common/timepicker/lib/bootstrap-datepicker.css" />

  <script type="text/javascript" src="{{ url('/') }}/resources/common/pickadate/lib/picker.js"></script>
  <script type="text/javascript" src="{{ url('/') }}/resources/common/pickadate/lib/picker.time.js"></script>
  <script type="text/javascript" src="{{ url('/') }}/resources/common/pickadate/lib/picker.date.js"></script>
  
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/resources/common/pickadate/lib/themes/default.css" />
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/resources/common/pickadate/lib/themes/default.time.css" />
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/resources/common/pickadate/lib/themes/default.date.css" />
  <script type="text/javascript">

    function NavigateTo(theUrl)
    {
      document.location.href = theUrl;
    }

    function validateForm() 
    {
      var ScheduleCreated = "<?php echo $created; ?>";
      var from_$input = $('#monday_from').pickatime();
      var fromPicker = from_$input.pickatime('picker');

      var monday_from = fromPicker.get('value');

      from_$input = $('#monday_till').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var monday_till = fromPicker.get('value');

      from_$input = $('#tuesday_from').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var tuesday_from = fromPicker.get('value');

      from_$input = $('#tuesday_till').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var tuesday_till = fromPicker.get('value');

      from_$input = $('#wednesday_from').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var wednesday_from = fromPicker.get('value');

      from_$input = $('#wednesday_till').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var wednesday_till = fromPicker.get('value');

      from_$input = $('#thursday_from').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var thursday_from = fromPicker.get('value');

      from_$input = $('#thursday_till').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var thursday_till = fromPicker.get('value');

      from_$input = $('#friday_from').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var friday_from = fromPicker.get('value');

      from_$input = $('#friday_till').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var friday_till = fromPicker.get('value');

      from_$input = $('#saturday_from').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var saturday_from = fromPicker.get('value');

      from_$input = $('#saturday_till').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var saturday_till = fromPicker.get('value');

      from_$input = $('#sunday_from').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var sunday_from = fromPicker.get('value');

      from_$input = $('#sunday_till').pickatime();
      fromPicker = from_$input.pickatime('picker');

      var sunday_till = fromPicker.get('value');

      if(monday_from == "" || monday_from == null){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(tuesday_from == "" || tuesday_from == null){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(wednesday_from == "" || wednesday_from == null){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(thursday_from == "" || thursday_from == null){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(friday_from == "" || friday_from == null){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(saturday_from == "" || saturday_from == null){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(sunday_from == "" || sunday_from == null){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(monday_from > monday_till){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(tuesday_from > tuesday_till){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(wednesday_from > wednesday_till){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(thursday_from > thursday_till){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(friday_from > friday_till){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(saturday_from > saturday_till){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      if(sunday_from > sunday_till){
        alert("Time is invalid. Please re-enter.");
        return false;
      }

      return true;
  
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
                                    <script>
                                      $(function() {
                                        $('#monday_from').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('monday_till', null,  [ 'class' => 'form-control1','id' => 'monday_till', 'placeholder' => 'Till']) !!}

                                    </div>
                                    <script>
                                      $(function() {
                                        $('#monday_till').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
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
                                    <script>
                                      $(function() {
                                        $('#tuesday_from').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('tuesday_till', null,  [ 'class' => 'form-control1','id' => 'tuesday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                    <script>
                                      $(function() {
                                        $('#tuesday_till').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
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
                                    <script>
                                      $(function() {
                                        $('#wednesday_from').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('wednesday_till', null,  [ 'class' => 'form-control1','id' => 'wednesday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                    <script>
                                      $(function() {
                                        $('#wednesday_till').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
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
                                    <script>
                                      $(function() {
                                        $('#thursday_from').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('thursday_till', null,  [ 'class' => 'form-control1','id' => 'thursday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                    <script>
                                      $(function() {
                                        $('#thursday_till').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
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
                                    <script>
                                      $(function() {
                                        $('#friday_from').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('friday_till', null,  [ 'class' => 'form-control1','id' => 'friday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                    <script>
                                      $(function() {
                                        $('#friday_till').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
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
                                    <script>
                                      $(function() {
                                        $('#saturday_from').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('saturday_till', null,  [ 'class' => 'form-control1','id' => 'saturday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                    <script>
                                      $(function() {
                                        $('#saturday_till').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
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
                                    <script>
                                      $(function() {
                                        $('#sunday_from').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
                                </div>  
                                <div class="col-xs-2">
                                    <div class="input-group"> 
                                      {!! Form::text('sunday_till', null,  [ 'class' => 'form-control1','id' => 'sunday_till', 'placeholder' => 'Till']) !!}
                                    </div>
                                    <script>
                                      $(function() {
                                        $('#sunday_till').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                      });
                                    </script>
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