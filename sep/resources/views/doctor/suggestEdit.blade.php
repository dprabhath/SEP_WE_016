@extends('template/template_user')
    
@section('head')
<script type="text/javascript">

    function NavigateTo(theUrl)
    {
      document.location.href = theUrl;
    }

    function validateForm() 
    {
        
    }

    function fillTextbox()
    {
        var field = document.getElementById("field").value;

        if(field == 'edu')
        {
            var fvalue = document.getElementById("fieldValue");
            fvalue.value = "<?php echo $doctor->eduqual; ?>";
        }
        if(field == 'prof')
        {
            var fvalue = document.getElementById("fieldValue");
            fvalue.value = "<?php echo $doctor->profqual; ?>";
        }
        if(field == 'hos')
        {
            var fvalue = document.getElementById("fieldValue");
            fvalue.value = "<?php echo $doctor->hospital; ?>";
        }
        if(field == 'email')
        {
            var fvalue = document.getElementById("fieldValue");
            fvalue.value = "<?php echo $doctor->email; ?>";
        }
        if(field == 'tele')
        {
            var fvalue = document.getElementById("fieldValue");
            fvalue.value = "<?php echo $doctor->phone; ?>";
        }
        if(field == 'ads')
        {
            var fvalue = document.getElementById("fieldValue");
            fvalue.value = "<?php echo $doctor->address; ?>";
        }
        //document.getElementById("fieldValue").value = {!! $doctor->eduqual !!};

        //alert(field);
    }
</script>

@stop

@section('navbar')
@stop
    
        
@section('body')

   
    <div class="panel-body1" onload ="fillTextbox()">
        <div  class="panel-footer">
            <h3><span class="semi-bold">Suggest Changes : Dr {!! $doctor->first_name !!} {!! $doctor->last_name !!}</span></h3>
        </div>
            <div class="tab-content">
                
                        <div class="tab-pane active" id="horizontal-form">
                             {!! Form::open(array('class' => 'form-horizontal', 
                                                  'files' => true, 'name' => 'editForm', 
                                                  'onsubmit' => 'return validateForm()')) !!}
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Field : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::select('field', ['prof' => 'Professional Qualifications', 'edu' => 'Educational Qualifications', 'hos' => 'Hospital','tele' => 'Telephone', 'email' => 'Email', 'ads' => 'Address'], 'prof', ['class' => 'form-control1', 'onchange' => 'fillTextbox()','id' => 'field']) !!}
                                    </div>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Value :</label>
                                    <div class="col-sm-8">
                                       {!! Form::textarea('fieldValue', null,  [ 'class' => 'form-control1', 'id' => 'fieldValue', 'style' => 'height:100px']) !!}
                                    </div>
                                </div>
                    
                             
                        </div>
                    </div>
                    <div class="panel-footer">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                 {!! Form::submit('Submit', ['class' => 'btn btn_5 btn-lg btn-info']) !!}  
                <input class="btn btn_5 btn-lg btn-info" value="Cancel" onclick="NavigateTo('../{!! $doctor->id!!}')">
                {!! Form::close() !!}
            </div>
        </div>
     </div>
          
        </div>
       
@stop

@section('footer')
@stop