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

</div>

@stop

@section('footer')
@stop