@extends('template/template_user')
	
@section('head')

@stop

@section('navbar')
@stop
	
		
@section('body')

   
    <div class="panel-body1">
        <div  class="panel-footer">
            <h3><span class="semi-bold">Add New Physician</span></h3>
        </div>

            <div class="tab-content">
                        
                        <div class="tab-pane active" id="horizontal-form">
                             {!! Form::open(array('class' => 'form-horizontal', 
                                                  'files' => true, 'name' => 'editForm')) !!}

                                <div class="form-group">
                                    <label style="padding-left:60px"> Fields marked with * must be filled. </label>
                                    
                
                                </div>                  
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> First Name* : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::text('fname', null,  [ 'class' => 'form-control1', 'id' => 'fname']) !!}
                                    </div>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Last Name* : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::text('lname', null,  [ 'class' => 'form-control1', 'id' => 'lname']) !!}
                                    </div>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Specialization* : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::text('spec', null,  [ 'class' => 'form-control1', 'id' => 'spec']) !!}
                                    </div>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Notes :</label>
                                    <div class="col-sm-8">
                                       {!! Form::textarea('notes', null,  [ 'class' => 'form-control1','id' => 'notes']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Professional Qualifications :</label>
                                    <div class="col-sm-8">
                                       {!! Form::textarea('notes', null,  [ 'class' => 'form-control1', 'style' => 'height:100px', 'id' => 'profqual']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Educational Qualifications :</label>
                                    <div class="col-sm-8">
                                       {!! Form::textarea('notes', null,  [ 'class' => 'form-control1','style' => 'height:100px', 'id' => 'eduqual']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Hospital : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('spec', null,  [ 'class' => 'form-control1', 'id' => 'hospital']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Telephone : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('spec', null,  [ 'class' => 'form-control1', 'id' => 'phone']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Email : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('spec', null,  [ 'class' => 'form-control1','id' => 'email']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Address : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('spec', null,  [ 'class' => 'form-control1','id' => 'address']) !!}
                                    </div>
                                </div>
                             
                        </div>
                    </div>
                    <div class="panel-footer">
                      <div class="row">
                          <div class="col-sm-8 col-sm-offset-2">
                               {!! Form::submit('Submit', ['class' => 'btn btn_5 btn-lg btn-info']) !!}  
                              <button class="btn-default btn">Cancel</button>
                              {!! Form::close() !!}
                          </div>
                      </div>
                    </div>
          
        </div>
       
@stop

@section('footer')
@stop