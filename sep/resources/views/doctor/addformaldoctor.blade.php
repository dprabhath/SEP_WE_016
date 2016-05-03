@extends('admintemplate/template_admin')
	
@section('head')

<script type="text/javascript">

    function NavigateTo(theUrl)
    {
      document.location.href = theUrl;
    }

    function ValidateEmail()
    {
         var emailID = document.getElementById("email").value;
         atpos = emailID.indexOf("@");
         dotpos = emailID.lastIndexOf(".");
         
         if (atpos < 1 || ( dotpos - atpos < 2 )) 
         {
            alert("Please enter a valid Email Address")
            document.editForm.email.focus() ;
            return false;
         }
         return( true );
    }

    function ValidatePhone(phone)
    {
        if(phone.length == 10) {
            if(isNaN(phone)) {
                alert("Phone Number is Invalid.");
                return false;
            }
            else {
                return true;
            }   
        } 
        else {
            alert("Phone Number is Invalid.");
            return false;
        }
    }

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
        var city = document.getElementById("city").value;

        var path = image.split("\\");

        var filetype = path[path.length - 1].split(".");

        var isFilled = true;

        if (filetype[filetype.length - 1] == null || filetype[filetype.length - 1] == "") {
           
        }
        else {
            if ((filetype[filetype.length - 1] == "png") || (filetype[filetype.length - 1] == "PNG")|| (filetype[filetype.length - 1] == "jpg")) {
            }
            else
            {
                alert(filetype[filetype.length - 1] + " is not a supported image format.")
                return false;
            }
        }
        if (notes == null || notes == "") {
          alert("A field is empty.");
          return false;
        }
        if (spec == null || spec == "") {
          alert("A field is empty.");
          return false;
        }
        if (prof == null || prof == "") {
          alert("A field is empty.");
          return false;
        }
        if (edu == null || edu == "") {
          alert("A field is empty.");
          return false;
        }
        if (hospital == null || hospital == "") {
          alert("A field is empty.");
          return false;
        }
        if (phone == null || phone == "") {
          alert("A field is empty.");
          return false;
        }
        if (email == null || email == "") {
          alert("A field is empty.");
          return false;
        }
        if (address == null || address == "") {
          alert("A field is empty.");
          return false;
        }
        if (city == null || city == "") {
          alert("A field is empty.");
          return false;
        }
        if(!ValidateEmail()) {
          return false;
        }
        if(!ValidatePhone(phone)) {
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
            <h3><span class="semi-bold">Add New Formal Physician</span></h3>
        </div>

            <div class="tab-content">
                        
                        <div class="tab-pane active" id="horizontal-form">
                             {!! Form::open(array('class' => 'form-horizontal', 
                                                  'files' => true, 'name' => 'editForm', 
                                                  'onsubmit' => 'return validateForm()')) !!}
                    
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Display Picture : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::file('image', ['id' => 'image']); !!}
                                    </div>
                                   
                                </div>                  
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> First Name : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::text('fname', null,  [ 'class' => 'form-control1', 'id' => 'fname']) !!}
                                    </div>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Last Name : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::text('lname', null,  [ 'class' => 'form-control1', 'id' => 'lname']) !!}
                                    </div>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Specialization : </label>
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
                                       {!! Form::textarea('profqual', null,  [ 'class' => 'form-control1', 'style' => 'height:100px', 'id' => 'profqual']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Educational Qualifications :</label>
                                    <div class="col-sm-8">
                                       {!! Form::textarea('eduqual', null,  [ 'class' => 'form-control1','style' => 'height:100px', 'id' => 'eduqual']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Hospital : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('hospital', null,  [ 'class' => 'form-control1', 'id' => 'hospital']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Telephone : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('phone', null,  [ 'class' => 'form-control1', 'id' => 'phone']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Email : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('email', null,  [ 'class' => 'form-control1','id' => 'email']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Street Address : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('address', null,  [ 'class' => 'form-control1','id' => 'address']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> City : </label>
                                    <div class="col-sm-8">
                                        {!! Form::text('city', null,  [ 'class' => 'form-control1','id' => 'city']) !!}
                                    </div>
                                </div>
                             
                        </div>
                    </div>
                    <div class="panel-footer">
                      <div class="row">
                          <div class="col-sm-8 col-sm-offset-2">
                               {!! Form::submit('Submit', ['class' => 'btn btn_5 btn-lg btn-info']) !!}  
                              {!! Form::close() !!}
                          </div>
                      </div>
                    </div>
          
        </div>
  

@stop

@section('footer')
@stop