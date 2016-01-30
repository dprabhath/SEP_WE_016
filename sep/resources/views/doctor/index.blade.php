@extends('template/template_user')
	
@section('head')

    
@stop

@section('navbar')
@stop
	
		
@section('body')



        <div id="content" align="left"  style="padding-right:0px;">
            <div class="row">
                


                <div class="col-md-3 stats-info" style="margin-left:0px;">
                 {!! Form::open() !!}
                    <div class="panel-heading">
                        <h4 class="panel-title">Sort</h4>
                        <div class="panel-body">
                                    <div class="radio block">
                                        {!! Form::radio('sorttype', 'rating', 'true') !!}
                                        <label>  Rating</label>
                                    </div>
                                    <div class="radio block">
                                        {!! Form::radio('sorttype', 'first_name') !!}
                                        <label>  First Name</label>
                                    </div>
                                    <div class="radio block">
                                        {!! Form::radio('sorttype', 'last_name') !!}
                                        <label>  Last Name</label>
                                    </div>
                        </div>
                         <h4 class="panel-title">Filter</h4>   
                        <div class="panel-body">                    
                            <ul class="list-unstyled">
                                <li>By Specialization</li>
                                    <div class="radio block">
                                         {!! Form::radio('spec', 'all', 'true') !!}
                                        <label> All</label>
                                    </div>
                                    <div class="radio block">
                                         {!! Form::radio('spec', 'spec1') !!}
                                        <label> Specialization 1</label>
                                    </div>
                                    <div class="radio block">
                                         {!! Form::radio('spec', 'spec2') !!}
                                        <label> Specialization 2</label>
                                    </div>
                                    <div class="radio block">
                                         {!! Form::radio('spec', 'spec3') !!}
                                        <label> Specialization 3</label>
                                    </div>
                                    <div class="radio block">
                                         {!! Form::radio('spec', 'spec4') !!}
                                        <label> Specialization 4</label>
                                    </div>
                                <li>By Location</li>
                                   <div class="radio block">
                                         {!! Form::radio('location', 'all', 'true') !!}
                                        <label> All</label>
                                   </div>
                                   <div class="radio block">
                                         {!! Form::radio('location', 'loc1') !!}
                                        <label> Location 1</label>
                                   </div>
                                    <div class="radio block">
                                         {!! Form::radio('location', 'loc2') !!}
                                        <label> Location 2</label>
                                   </div>
                                   <div class="radio block">
                                         {!! Form::radio('location', 'loc3') !!}
                                        <label> Location 3</label>
                                   </div>

                            </ul>
                            {!! Form::submit('Submit', ['class' => 'btn btn_5 btn-lg btn-info']) !!}
                           
                        </div>
                        {!! Form::close() !!}
                    </div>
                
                </div>

                <div class="col-md-9" >
                    <div class="tab-content" style="margin:0px;">
                        <div id="home" class="tab-pane fade in active r3_counter_box">
                            <div class="list-group list-group-alternate"> 
                    
                                @foreach ($doctors as $doctor)
                                    <a href="doctors/{{ $doctor->id }}" class="list-group-item">
                                        <span class="badge badge-info">{!! $doctor->rating !!}</span> 
                                        {!! $doctor->first_name !!} {!! $doctor->last_name !!} 
                                    </a> 
                                @endforeach   
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>      
        </div><!-- #content -->

@stop

@section('footer')
@stop