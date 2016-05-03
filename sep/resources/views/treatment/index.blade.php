@extends('template/template_user')
	
@section('head')


@stop

@section('navbar')
@stop
	<script type="text/javascript">
		function NavigateTo(theUrl)
		{
			document.location.href = theUrl;
		}
	</script>
		
@section('body')


<div class="panel-body1">
       <div class="panel-footer">         
       		<h1> Treatments </h1>
       </div>

       <div >
			<div class="list-group list-group-alternate"> 

				@foreach ($treatments as $treatment)
        	
        			<a href="#" class="list-group-item" onclick="NavigateTo('treatments/{{ $treatment->id }}')"> {!! $treatment->name !!} </a> 
       		
	        	@endforeach 
				
			</div>
	   </div>
	   <div class="panel-footer">
           	<div class="row">
                <div class="col-sm-8">
                @if($user->level == 2)
                    <input class="btn btn_5 btn-lg btn-info" value="Add New Treatment" onclick="NavigateTo('treatments/new')">
                @endif
                </div>
            </div>
       	</div>

</div>

@stop

@section('footer')
@stop