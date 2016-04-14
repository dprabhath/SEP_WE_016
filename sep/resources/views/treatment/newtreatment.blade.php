@extends('template/template_user')
	
@section('head')
    <script type="text/javascript">
    function validateForm() 
    {
        var name = document.getElementById("tname").value;
        var desc = document.getElementById("description").value;
        var cond = document.getElementById("condition").value;
        var signs = document.getElementById("wsigns").value;

        var image = document.getElementById("image1").value;

        var path = image.split("\\");

        var filetype = path[path.length - 1].split(".");

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

        image = document.getElementById("image2").value;

        path = image.split("\\");

        filetype = path[path.length - 1].split(".");

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

        image = document.getElementById("image3").value;

        path = image.split("\\");

        filetype = path[path.length - 1].split(".");

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

        image = document.getElementById("image4").value;

        path = image.split("\\");

        filetype = path[path.length - 1].split(".");

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
        
    
        if ((desc == null || desc == "") || (name == null || name == "") || (cond == null || cond == "")|| (signs == null || signs == "")) 
        {
           alert("Fields marked with * must be filled.");
           return false;
        }
        else
        {
            return true;
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
            <h3><span class="semi-bold">Add New Treatment</span></h3>
        </div>

            <div class="tab-content">
                        
                        <div class="tab-pane active" id="horizontal-form">
                             {!! Form::open(array('class' => 'form-horizontal', 
                                                  'files' => true, 'name' => 'editForm', 
                                                  'onsubmit' => 'return validateForm()')) !!}
                                  
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Treatment Name : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::text('tname', null,  [ 'class' => 'form-control1', 'id' => 'tname']) !!}
                                    </div>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Targeted Condition :</label>
                                    <div class="col-sm-8">
                                       {!! Form::textarea('condition', null,  [ 'class' => 'form-control1','id' => 'condition']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Warning Signs : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::textarea('wsigns', null,  [ 'class' => 'form-control1','style' => 'height:100px', 'id' => 'wsigns']) !!}
                                    </div>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Description : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::textarea('description', null,  [ 'class' => 'form-control1','style' => 'height:300px', 'id' => 'description']) !!}
                                    </div>
                                   
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Image 1 : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::file('image1', ['id' => 'image1']); !!}
                                    </div>
                                   
                                </div> 
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Image 2 : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::file('image2', ['id' => 'image2']); !!}
                                    </div>
                                   
                                </div>  
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Image 3 : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::file('image3', ['id' => 'image3']); !!}
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label"> Image 4 : </label>
                                    <div class="col-sm-8">
                                        
                                        {!! Form::file('image4', ['id' => 'image4']); !!}
                                    </div>
                                </div>  
                        </div>
                    </div>
                    <div class="panel-footer">
                      <div class="row">
                          <div class="col-sm-8 col-sm-offset-2">
                               {!! Form::submit('Submit', ['class' => 'btn btn_5 btn-lg btn-info']) !!}  
                              <input class="btn btn_5 btn-lg btn-info" value="Back" onclick="NavigateTo('../treatments')">
                          </div>
                      </div>
                    </div>
          
        </div>
       
@stop

@section('footer')
@stop