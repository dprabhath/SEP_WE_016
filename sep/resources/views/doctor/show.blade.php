@extends('template/template_user')
	
@section('head')

@stop

@section('navbar')
@stop
	
		
@section('body')



        <div id="content" align="left" style="padding-right:0px;">
            <div class="row">
                <div class="col-md-9 stats-info" style="margin-left:0px;">
                    <div class="panel-heading">
                      
                        <div class="panel-body">

                            <div class="panel-body">
                                <div class="col-md-4" float="left">
                                    <a href="#" class="thumbnail">
                                        <img src="http://placehold.it/300x200" alt="">
                                    </a>
                                </div>
                                <div class="col-md-5" >
                                    <h4 class="panel-title"  style="margin-top:50px">
                                        {!! $doctor->first_name !!} {!! $doctor->last_name !!}
                                    </h4>
                                </div>
                            </div>
                            <div class="panel-body">

                                <ul class="list-group">
                                    <li class="list-group-item"> 
                                        <h4 id="h4" style="margin-left:10px"> Specialization: {!! $doctor->specialization !!}</h4>
                                    </li>
                                    <li class="list-group-item">
                                        <h4 id="h4" style="margin-left:10px"> Location: {!! $doctor->location !!}</h4>
                                    </li>
                                    <a href="#" onclick="history.back()" class="btn btn_5 btn-lg btn-info" style="margin-top:50px">Back</a>   
                                </ul>
                            </div>
                        </div>

                    </div>
                
                </div>

                <div class="col-md-3" >
                    <div class="tab-content" style="margin:0px;">
                        <div id="home" class="tab-pane fade in active r3_counter_box">
                            
                          <h4 id="h4" style="margin-left:10px"> Rating : {!! $doctor->rating !!} / 10</h4>
                        </div>
                    </div>

                </div>

            </div>
            
        </div>

@stop

@section('footer')
@stop