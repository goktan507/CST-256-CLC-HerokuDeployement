	<?php if(session_status() != PHP_SESSION_ACTIVE){
	    session_start();
	}?>
@extends('layouts.app')
@section('title', 'Jobs')
@section('content')
<style>
th{
    word-wrap: break-word;
    text-align: center;
}

.table tr>td{
  padding-bottom: 2em;
  text-align: center;
  word-wrap: break-word;
}
.table{
    table-layout: fixed; 
    width: 80%;
    align: center;
}


input[type=submit]{
    width: 5em;   
}
</style>

	<div align="center">
    	<table class="table">
    	<thead class="thead-dark">
    		<tr align="center">
    			<th>Name</th>
    			<th>Email</th>
    			<th>Job</th>
    			<th>Skills</th>
    			<th>Education</th>
    			<th colspan="2" style="width: 15%"> Action </th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($data as $job)
    			<tr>
    				<td>{{ $job['name'] }}</td>
    				<td>{{ $job['email'] }}</td>
    				<td>{{ $job['job'] }}</td>
    				<td>{{ $job['skills'] }}</td>
    				<td>{{ $job['education'] }}</td>
    				<td>
    					<form action="{{ action('UserController@viewJob') }}" method="post">
    					{{ csrf_field() }}
    						<input type="hidden" id="name" name="name" value="{{ $job['name'] }}">
    						<input type="hidden" id="email" name="email" value="{{ $job['email'] }}">
    						<input type="hidden" id="job" name="job" value="{{ $job['job'] }}">
    						<input type="hidden" id="skills" name="skills" value="{{ $job['skills'] }}">
    						<input type="hidden" id="education" name="education" value="{{ $job['education'] }}">
    						<input type="submit" class="btn btn-primary" name="viewJob" value="View"/>
    					</form>
    				</td>
    				@if($job['userID'] == Auth::user()->id)
    				<td>
    					<form action="{{ action('UserController@deletePortfolio') }}" method="post">
    					{{ csrf_field() }}
    						<input type="hidden" id="userID" name="userID" value="{{ $job['userID'] }}">
    						<input type="submit" class="btn btn-dark" name="deletePortfolio" value="Delete"/>
    					</form>
    				</td>
    				@elseif($_SESSION['admin'] == true)
    				<td>
    					<form action="{{ action('UserController@deletePortfolio') }}" method="post">
    					{{ csrf_field() }}
    						<input type="hidden" id="userID" name="userID" value="{{ $job['userID'] }}">
    						<input type="submit" class="btn btn-dark" name="deletePortfolio" value="Delete"/>
    					</form>
    				</td>
    				@endif
    			</tr>
    		@endforeach
    	</tbody>
    	</table>
	</div>
@endsection