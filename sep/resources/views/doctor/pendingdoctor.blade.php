@extends('admintemplate/template_admin')
	
@section('head')

@stop

@section('navbar')
@stop
	
		
@section('body')

<div class="col-md-12 graphs">
       <div class="xs">
        <h3>Pending Doctors</h3>
            <table id="indextable" class="table table-striped">
     <thead>
        <tr>
          <th> <a href="javascript:SortTable(0,'T');"> First Name </a> </th>
          <th> <a href="javascript:SortTable(1,'T');"> Last Name </a> </th>
          <th> <a href="javascript:SortTable(2,'T');"> Specialization </a> </th>
          <th> <a href="javascript:SortTable(3,'T');"> Hospital </a> </th>
          <th>User Rating</th>
        </tr>
      </thead>
      <tbody>
        
            @foreach ($doctors as $doctor)
            
                <tr onmouseover="ChangeColor(this, true);" 
                    onmouseout="ChangeColor(this, false);" 
                    onclick="NavigateTo('doctors/{{ $doctor->id }}')" style="cursor: pointer;">

                    <td> <a href="#doccont" data-toggle="collapse"> {!! $doctor->first_name !!} </a></td>
                    <td> {!! $doctor->last_name !!} </td>
                    <td> {!! $doctor->specialization !!} </td>
                    <td> Hospital </td>
                    <td> {!! $doctor->rating !!} </td>

                    <div id="doccont" class="collapse">{!! $doctor->first_name !!}</div>

                </tr>  
            @endforeach 
            
      </tbody>
    </table>
        
        </div>
  </div>
  

@stop

@section('footer')
@stop