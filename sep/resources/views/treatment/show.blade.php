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
       <div class="panel-footer">         
          <h1> {!! $treatment->name !!} : Dr. {!! $doctor->first_name !!} {!! $doctor->last_name !!}</h1>
       </div>

       <div class="grid_3 grid_5">
         <h3>Targeted Condition</h3>
            <div class="but_list">
           
              <div class="well">
                  {!! $treatment->conditions1 !!}
              </div>
           
            </div>
            <h3>Description</h3>
            <div class="but_list">
           
              <div class="well">
                  {!! $treatment->description !!}
              </div>
           
            </div>

            <h3>Warning Signs</h3>
            <div class="but_list">
           
              <div class="well">
                  {!! $treatment->conditions2 !!}
              </div>
           
            </div>

            @if($treatment->image1 != '' || $treatment->image2 != '' || $treatment->image3 != '' || $treatment->image4 != '')
            <h3>Images</h3>
            <div class="but_list">
           
              <div class="well">
              @if($treatment->image1 != '')
                  <img alt="" src="{{ url('/') }}/{!! $treatment->image1 !!}"  width="800" height="450">
              @endif
               @if($treatment->image2 != '')
                  <img alt="" src="{{ url('/') }}/{!! $treatment->image2 !!}"  width="800" height="450">
              @endif
               @if($treatment->image3 != '')
                  <img alt="" src="{{ url('/') }}/{!! $treatment->image3 !!}"  width="800" height="450">
              @endif
               @if($treatment->image4 != '')
                  <img alt="" src="{{ url('/') }}/{!! $treatment->image4 !!}"  width="800" height="450">
              @endif
              </div>
              
            </div>
            @endif
            
      </div>
      <div class="panel-footer">
          <div class="row">
              <div class="col-sm-8">
                  <input class="btn btn_5 btn-lg btn-info" value="Back" onclick="NavigateTo('../treatments')">
              </div>
          </div>
      </div>
</div>

    
@stop

@section('footer')
@stop