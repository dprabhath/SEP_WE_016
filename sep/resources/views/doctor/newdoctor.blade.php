@extends('template/template_user')
	
@section('head')
    <script type="text/javascript">

    function ValidateEmail()
    {
         var emailID = document.getElementById("email").value;
         atpos = emailID.indexOf("@");
         dotpos = emailID.lastIndexOf(".");
         
         if (atpos < 1 || ( dotpos - atpos < 2 )) 
         {
            alert("Please enter correct email ID")
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
        var fname = document.getElementById("fname").value;
        var lname = document.getElementById("lname").value;
        var email = document.getElementById("email").value;
        var phone = document.getElementById("phone").value;

        if ((spec == null || spec == "") || (fname == null || fname == "") || (lname == null || lname == "")) 
        {
           alert("Fields marked with * must be filled.");
           return false;
        }
        else
        {
            if((email == "") && (phone == ""))
                return true;

            if(email == "")
                return ValidatePhone(phone);

            if(phone == "")
                return ValidateEmail();

            return (ValidateEmail() && ValidatePhone(phone));
        }
    }

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
            <h3><span class="semi-bold">Add New Physician</span></h3>
        </div>

            <div class="tab-content">
                        
                        <div class="tab-pane active" id="horizontal-form">
                             {!! Form::open(array('class' => 'form-horizontal', 
                                                  'files' => true, 'name' => 'editForm', 
                                                  'onsubmit' => 'return validateForm()')) !!}

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
                              <input class="btn btn_3 btn-lg btn-info" value="Cancel" onclick="NavigateTo('doctors')">
                              {!! Form::close() !!}
                          </div>
                      </div>
                    </div>
          
        </div>
       
@stop

@section('footer')
@stop