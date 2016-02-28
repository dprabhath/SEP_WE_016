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


<div class="col-md-12 inbox_right">
          <div class="Compose-Message">               
                <div class="panel panel-default">
                    <div class="panel-heading" >
                        <h3><span class="semi-bold">Pending Treatment Details : {!! $treatment->name !!} </span></h3>
                    </div>
                    <div class="grid_3 grid_5">
                    
                        <div class="but_list">
           
                          <div class="well">
                              Added by {!! $treatment->user!!} on {!! $treatment->created_at!!}
                          </div>
           
                        </div>
                        <h3>Description</h3>
                        <div class="but_list">
           
                          <div class="well">
                             {!! $treatment->description!!} 
                          </div>
           
                        </div>
                       
                       
                          <input class="btn btn_5 btn-lg btn-info" type="submit" value="Back" onclick="NavigateTo('../pendingtreatments')">

                        </div>
                      
                 </div>
              </div>
         </div>
  

@stop

@section('footer')
@stop