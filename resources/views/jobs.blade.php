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

tr>th{
  padding-bottom: 2em;
}
.table{
    table-layout: fixed; width: 80%;
    align: center;
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
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($data as $job)
    			<tr>
    				<th>{{ $job['name'] }}</th>
    				<th>{{ $job['email'] }}</th>
    				<th>{{ $job['job'] }}</th>
    				<th>{{ $job['skills'] }}</th>
    				<th>{{ $job['education'] }}</th>
    				@if($job['userID'] == Auth::user()->id)
    				<th>
    					<form action="{{ action('UserController@deletePortfolio') }}" method="post">
    					{{ csrf_field() }}
    						<input type="hidden" id="userID" name="userID" value="{{ $job['userID'] }}">
    						<input type="submit" class="btn btn-dark" name="deletePortfolio" value="Delete"/>
    					</form>
    				</th>
    				@elseif($_SESSION['admin'] == true)
    				<th>
    					<form action="{{ action('UserController@deletePortfolio') }}" method="post">
    					{{ csrf_field() }}
    						<input type="hidden" id="userID" name="userID" value="{{ $job['userID'] }}">
    						<input type="submit" class="btn btn-dark" name="deletePortfolio" value="Delete"/>
    					</form>
    				</th>
    				@endif
    			</tr>
    		@endforeach
    	</tbody>
    	</table>
	</div>
@endsection