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
                        <h4 class="panel-title">Filters</h4>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li>By Name</li>
                                   
                                    <div class="radio block"><label><input name="filtername" type="radio" checked=""> First Name</label></div>
                                    <div class="radio block"><label><input name="filtername" type="radio"> Last Name</label></div>
                                <li>By Specialization</li>
                                   
                                    <div class="radio block"><label><input name="filterspec" type="radio" > Specialization 1</label></div>
                                    <div class="radio block"><label><input name="filterspec" type="radio"> Specialization 2</label></div>
                                    <div class="radio block"><label><input name="filterspec" type="radio" > Specialization 3</label></div>
                                    <div class="radio block"><label><input name="filterspec" type="radio"> Specialization 4</label></div>
                                <li>By Location</li>
                                   
                                    <div class="radio block"><label><input name="filterloc" type="radio" > Location 1</label></div>
                                    <div class="radio block"><label><input name="filterloc" type="radio"> Location 2</label></div>
                                    <div class="radio block"><label><input name="filterloc" type="radio" > Location 3</label></div>
                                    <div class="radio block"><label><input name="filterloc" type="radio"> Location 4</label></div>
                            </ul>
                        </div>

                    </div>
                
                </div>

                <div class="col-md-3" >
                    <div class="tab-content" style="margin:0px;">
                        <div id="home" class="tab-pane fade in active r3_counter_box">
                            <div id="home" class="tab-pane fade in active r3_counter_box">
                            <div class="list-group list-group-alternate"> 

                                    

                            </div>
                            
                        </div>
                          
                        </div>
                    </div>

                </div>

            </div>
            
        </div>

@stop

@section('footer')
@stop