@extends('template/template_user')
    
@section('head')
<script type="text/javascript">
    function validateForm() 
    {
        var spec = document.getElementById("spec").value;
        var notes = document.getElementById("notes").value;
        var prof = document.getElementById("profqual").value;
        var edu = document.getElementById("eduqual").value;
        var hospital = document.getElementById("hospital").value;
        var phone = document.getElementById("phone").value;
        var email = document.getElementById("email").value;
        var address = document.getElementById("address").value;
        var image = document.getElementById("image").value;

        var path = image.split("\\");

        var filetype = path[path.length - 1].split(".");

        var isFilled = true;

        if (filetype[filetype.length - 1] == null || filetype[filetype.length - 1] == "") 
        {
           
        }
        else
        {
            if ((filetype[filetype.length - 1] == "png") || (filetype[filetype.length - 1] == "PNG")|| (filetype[filetype.length - 1] == "jpg"))
            {
                return true;
            }
            else
            {
                alert(filetype[filetype.length - 1] + " is not a supported image format.")
                return false;
            }
        }
        if (notes == null || notes == "") 
        {
           
        }
        else
        {
            return true;
        }
        if (spec == null || spec == "") 
        {
            
        }
        else
        {
            return true;
        }
        if (prof == null || prof == "") 
        {
         
        }
        else
        {
            return true;
        }
        if (edu == null || edu == "") 
        {
          
        }
        else
        {
            return true;
        }
        if (hospital == null || hospital == "") 
        {
            
        }
        else
        {
            return true;
        }
        if (phone == null || phone == "") 
        {
          
        }
        else
        {
            return true;
        }
        if (email == null || email == "") 
        {
           
        }
        else
        {
            return true;
        }
        if (address == null || address == "") 
        {
          
        }
        else
        {
            return true;       
        }
        
        alert("At least one field must be updated.");
        return false;
    }
</script>

@stop

@section('navbar')
@stop
    
        
@section('body')

   
    <div class="panel-body1">
        <div  class="panel-footer">
            <h3><span class="semi-bold">Edit Doctor Profile : Dr {!! $doctor->first_name !!} {!! $doctor->last_name !!}</span></h3>
        </div>
            <div class="tab-content">
                        <div  class="row" style="margin:auto; width:30%; padding-top:30px; padding-bottom:30px;">
                            <img class="img-circle big-profile-pic p-t-10" alt="" src="{{ url('/') }}/{!! $doctor->imagepath !!}"  width="200" height="200">
                        </div>

                        <div class="tab-pane active" id="horizontal-form">
                             {!! Form::open(array('class' => 'form-horizontal', 
                                                  'files' => true, 'name' => 'editForm', 
                                                  'onsubmit' => 'return validateForm()')) !!}
                                <div class="form-group">
                                 <label for="focusedinput" class="col-sm-2 control-label"> Profile Picture : </label>
                                    <div class="col-sm-8">
                                        {!! Form::file('image', ['id' => 'image']); !!}
                                    </div>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Specialization : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::text('spec', null,  [ 'class' => 'form-control1', 'placeholder' => "$doctor->specialization", 'id' => 'spec']) !!}
                                    </div>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Notes :</label>
                                    <div class="col-sm-8">
                                       {!! Form::textarea('notes', null,  [ 'class' => 'form-control1', 'placeholder' => "$doctor->notes", 'id' => 'notes']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Professional Qualifications :</label>
                                    <div class="col-sm-8">
                                       {!! Form::textarea('profqual', null,  [ 'class' => 'form-control1', 'placeholder' => "$doctor->profqual", 'style' => 'height:100px', 'id' => 'profqual']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Educational Qualifications :</label>
                                    <div class="col-sm-8">
                                       {!! Form::textarea('eduqual', null,  [ 'class' => 'form-control1', 'placeholder' => "$doctor->eduqual", 'style' => 'height:100px', 'id' => 'eduqual']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Hospital : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('hospital', null,  [ 'class' => 'form-control1', 'placeholder' => "$doctor->hospital", 'id' => 'hospital']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Telephone : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('phone', null,  [ 'class' => 'form-control1', 'placeholder' => "$doctor->phone", 'id' => 'phone']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Email : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('email', null,  [ 'class' => 'form-control1', 'placeholder' => "$doctor->email", 'id' => 'email']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Address : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('address', null,  [ 'class' => 'form-control1', 'placeholder' => "$doctor->address", 'id' => 'address']) !!}
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