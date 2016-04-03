@extends('template/template_user')
	
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
	                               <input class="btn btn_5 btn-lg btn-info" value="Back" onclick="NavigateTo('../treatments')">
	                              {!! Form::close() !!}
	                          </div>
	                      </div>
                    	</div>
        </div>
</div>


        
    
@stop

@section('footer')
@stop