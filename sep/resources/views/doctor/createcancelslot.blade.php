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
      var from_$input = $('#from').pickatime();
      var fromPicker = from_$input.pickatime('picker');

      var till_$input = $('#till').pickatime();
      var tillPicker = till_$input.pickatime('picker');
      var date = document.getElementById("date");

      
      var fromTime = fromPicker.get('value');
      var tillTime = tillPicker.get('value');

      if(fromTime > tillTime)
      {
        alert("Invalid");
        return false;
      }
      else
      {
        return true;
      }

    }

</script>

@stop

@section('navbar')
@stop
	
		
@section('body')


<div class="panel-body1">
        <div  class="panel-footer">
            <h3><span class="semi-bold"> Create Cancel Slot</span></h3>
        </div>
        <div class="tab-content">
                        <div class="tab-pane active" id="horizontal-form">
                             {!! Form::open(array('class' => 'form-horizontal', 'files' => true, 'name' => 'editForm', 'onsubmit' => 'return validateForm()')) !!} 
                          <div class="col-lg-12" style="margin-top: 20px;">
                              <div class="col-xs-2">
                                    <label for="focusedinput" class="col-sm-2 control-label"> From</label>
          
                                </div>
                                <div class="col-xs-4">
                                    <div class="input-group"> 
                                      {!! Form::text('from', null,  [ 'class' => 'form-control1','id' => 'from']) !!}
                                    </div>
                                </div>  
                                <script>
                                  $(function() {
                                    $('#from').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                  });
                                </script>
                      
                          </div>

                          <div class="col-lg-12">
                              <div class="col-xs-2">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Till</label>
          
                                </div>
                                <div class="col-xs-4">
                                    <div class="input-group"> 
                                      {!! Form::text('till', null,  [ 'class' => 'form-control1','id' => 'till']) !!}
                                    </div>
                                    <script>
                                      $(function() {
                                        $('#till').pickatime( { formatSubmit: 'HH.i', hiddenName: true } );
                                    });
                                    </script>
                                </div>  
                      
                          </div>

                          <div class="col-lg-12">
                              <div class="col-xs-2">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Date</label>
          
                                </div>
                                <div class="col-xs-4">
                                    <div class="input-group"> 
                                      {!! Form::text('date', null,  [ 'class' => 'form-control1','id' => 'date']) !!}
                                    </div>
                                </div>  
                                <script>
                                  
                                  $(function() {
                                        $('#date').pickadate( { formatSubmit: 'yyyy/mm/dd', hiddenName: true });
                                    });
                                </script>
                      
                          </div>


        

            <script>
                $(function() {
                    $('#basicExample').timepicker();
                });
            </script>

                             
                                
                        </div>
                        <div class="panel-footer">
	                      <div class="row">
	                          <div class="col-sm-8">
	                               {!! Form::submit('Create Slot', ['class' => 'btn btn_5 btn-lg btn-info']) !!}  
	                               <input type="button" class="btn btn_5 btn-lg btn-info" value="Back" onclick="NavigateTo('../profile')">
	                              {!! Form::close() !!}
	                          </div>
	                      </div>
                    	</div>
        </div>
</div>


        
    
@stop

@section('footer')
@stop