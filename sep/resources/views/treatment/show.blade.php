@extends('template/template_user')
	
@section('head')

@stop

@section('navbar')
@stop
	
		
@section('body')

<div class="panel-body1">
       <div class="panel-footer">         
          <h1> {!! $treatment->name !!} </h1>
       </div>

       <div class="grid_3 grid_5">
         <h3>Description</h3>
            <div class="but_list">
           
              <div class="well">
                  {!! $treatment->description !!}
              </div>
           
            </div>
      </div>
</div>

    
@stop

@section('footer')
@stop