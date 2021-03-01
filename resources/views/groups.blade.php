	<?php if(session_status() != PHP_SESSION_ACTIVE){
	    session_start();
	}?>
@extends('layouts.app')
@section('title', 'Affinity Groups')
@section('content')
<style>

th{
    word-wrap: break-word;
    text-align: center;
}

.table tr>td{
  padding-bottom: 2em;
  text-align: center;
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
	
	@guest
		<h2 style="text-align: center">Please login first!</h2>
	@else
	<div align="center">
	<h2>Affinity Groups</h2>
    	<div style="padding: 10px">
        	<form action="{{ action('UserController@getCreateGroup') }}">
        		<input type="submit" class="btn btn-dark" name="createGroup" id="createGroup" value="Create"/> 
        	</form>
    	</div>
    	<table class="table">
    	<thead class="thead-dark">
    		<tr align="center">
    			<th>Name</th>
    			<th>Description</th>
    			<th>Owner</th>
    			<th>Members</th>
    			<th colspan="3" style="width: 30%"> Modify </th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($data as $group)
    			<tr>
    				<td>{{ $group['name'] }}</td>
    				<td>{{ $group['description'] }}</td>
    				<td>{{ $group['owner'] }}</td>
    				
    				<td> 
    				@foreach($group['members'] as $member)
    					{{ $member }} <br>
    				@endforeach
    				</td>
    				@if(!in_array(Auth::User()->name, $group['members']))
    				<td>
    					<form action="{{ action('UserController@joinGroup') }}" method="post">
    					{{ csrf_field() }}
    						<input type="hidden" id="groupID" name="groupID" value="{{ $group['groupID'] }}">
    						<input type="submit" class="btn btn-success" name="joinGroup" value="Join"/>
    					</form>
    				</td>
    				@else
    				<td>
    					<form action="{{ action('UserController@leaveGroup') }}" method="post">
    					{{ csrf_field() }}
    						<input type="hidden" id="groupID" name="groupID" value="{{ $group['groupID'] }}">
    						<input type="submit" class="btn btn-danger" name="leaveGroup" value="Leave"/>
    					</form>
    				</td>
    				@endif
    				@if(($group['userID'] == Auth::user()->id) OR ($_SESSION['admin'] == true))
    				<td>
    					<form action="{{ action('UserController@deleteGroup') }}" method="post">
    					{{ csrf_field() }}
    						<input type="hidden" id="groupID" name="groupID" value="{{ $group['groupID'] }}">
    						<input type="submit" class="btn btn-dark" name="deleteGroup" value="Delete"/>
    					</form>
    				</td>
    				<td>
    					<form action="{{ action('UserController@editGroup') }}" method="post">
    					{{ csrf_field() }}
    						<input type="hidden" id="groupID" name="groupID" value="{{ $group['groupID'] }}">
    						<input type="submit" class="btn btn-primary" name="editGroup" value="Edit"/>
    					</form>
    				</td>
    				@endif
    			</tr>
    		@endforeach
    	</tbody>
    	</table>
	</div>
	@endguest
@endsection