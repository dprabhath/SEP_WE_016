@extends('template/template_user')

@section('head')

<style type="text/css">

</style>
<script type="text/javascript">

	$(document).ready(function(){


	});
</script>
@stop

@section('navbar')
@stop


@section('body')

<div class="row">
	<div class="col-md-4">

		
	</div>
	<div class="col-md-8">
		

		
		
		{!! Form::open(['role'=>'form']) !!}
		<!-- form name -->
		
		{!! Form::close() !!}
		
	</div>
</div>
@stop
@section('footer')
@stop