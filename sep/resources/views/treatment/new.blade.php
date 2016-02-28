@extends('template/template_user')
	
@section('head')
    <script type="text/javascript">
    function validateForm() 
    {
        var name = document.getElementById("name").value;
        var desc = document.getElementById("desc").value;
        
    
        if ((desc == null || desc == "") || (name == null || name == "")) 
        {
           alert("Fields marked with * must be filled.");
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


        <div class="col-md-12 inbox_right">
        	<div class="Compose-Message">               
                <div class="panel panel-default">
                    <div class="panel-heading" >
                        <h3><span class="semi-bold">Add New Treatment</span></h3>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-info" style="display:none">
                            Please fill details to send a new message
                        </div>
						{!! Form::open(array('class' => 'form-horizontal', 'files' => true, 'name' => 'editForm', 'onsubmit' => 'return validateForm()')) !!}
							<hr>
								<label>Enter Treatment Name :  </label>
								{!! Form::text('name', null,  [ 'class' => 'form-control1 control3', 'id' => 'name']) !!}
								<label>Enter Treatment Description : </label>
								{!! Form::textarea('desc', null,  [ 'class' => 'form-control1 control2', 'id' => 'desc', 'rows' => '10']) !!}
							<hr>
							 {!! Form::submit('Submit', ['class' => 'btn btn_5 btn-lg btn-info']) !!}  
						 {!! Form::close() !!}
					</div>
                 </div>
              </div>
         </div>
       
@stop

@section('footer')
@stop