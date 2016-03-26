@extends('admintemplate/template_admin')
	
@section('head')

<script type="text/javascript">

    function NavigateTo(theUrl)
    {
      document.location.href = theUrl;
    }

   
</script>



@stop

@section('navbar')
@stop
	
		
@section('body')

  

  <div class="panel-body1">
        <div  class="panel-footer">
            <h3><span class="semi-bold">Generate Formal Physician Login</span></h3>
        </div>

            <div class="tab-content">
                        
                        <div class="tab-pane active" id="horizontal-form">
                             {!! Form::open(array('class' => 'form-horizontal', 
                                                  'files' => true, 'name' => 'editForm')) !!}
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Select Physician : </label>
                                    <div class="col-sm-8">
                                        {!! Form::select('doctors', $doctors, null, ['class' => 'form-control1']) !!}
                                    </div>
                                </div>     
                                <div class="form-group">
                                    <label style="padding-left:60px"> The Physician will be informed of Login details via Email. </label>
                                </div>                               
                        </div>
                    </div>
                    <div class="panel-footer">
                      <div class="row">
                          <div class="col-sm-8 col-sm-offset-2">
                               {!! Form::submit('Create', ['class' => 'btn btn_5 btn-lg btn-info']) !!}  
                              {!! Form::close() !!}
                          </div>
                      </div>
                    </div>
          
        </div>

@stop

@section('footer')
@stop