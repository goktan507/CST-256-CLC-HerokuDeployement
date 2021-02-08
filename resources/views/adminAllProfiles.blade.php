@extends('layouts.app')
@section('title', 'Admin All Profiles Page')
@section('content')
<head>
<style>
* {
  box-sizing: border-box;
}

.flex-container {
  display: flex;
  flex-wrap: wrap;
  font-size: 25px;
  text-align: center;
}

.flex-item {
  align: center;
  padding-top: 40px;
  padding-left: 40%;
  flex: 100%;
}

input[type=submit] {
    width: 6em;  height: 3em;
}

/* Responsive layout - makes a one column-layout instead of a two-column layout */
@media (max-width: 1000px) {
  .flex-item{
    flex: 100%;
  }
}
</style>
</head>
<body>
	<div align="center">
		@foreach($data as $user)
				<div class="flex-container" align="center">
    				<div class="flex-item">
    					<div class="card text-white bg-primary mb-3" style="max-width: 25rem;">
    					<form action="{{ action('UserController@editSelectedProfile') }}" method="post">
    					{{ csrf_field() }}
    					<input type="hidden" name="userID" value="{{ $user['userID'] }}"></input>
    						<div class="card-header">{{ $user['name'] }}  ({{ $user['email'] }})</div>
    						<div class="card-body">
    							@if($user['isAdmin'] == 1)
    								<p class="card-text">Admin</p>
    							@else
    								<p class="card-text">Normal User</p>
    							@endif
    							<ul class="list-group list-group-flush">
    								<li class="list-group-item bg-primary"></li>
        							<li class="list-group-item bg-primary">{{ $user['biography'] }}</li>
        							<li class="list-group-item bg-primary"></li>
                                    <li class="list-group-item bg-primary">{{ $user['address'] }}</li>   
                                    <li class="list-group-item bg-primary"></li>                             
                                </ul>
                                <h5 class="card-text" style="padding-top: 15px">Phone: {{ $user['phonenumber'] }} </h5>
                                <input type="submit" class="btn btn-dark" name="editUser" width="10px" height="5px" value="Edit"/>
                        	</div>
                            </form>
                            <div class="card-body">
							<form action="{{ action('UserController@adminSuspendProfile') }}" method="post">
								{{ csrf_field() }}
								<input type="hidden" name="userID" value="{{ $user['userID'] }}"></input>
								<input type="submit" class="btn btn-dark" name="suspend" value="Suspend"/>
							</form>
							</div>
							<div class="card-body">
							<form action="{{ action('UserController@adminDeleteProfile') }}" method="post">
								{{ csrf_field() }}
								<input type="hidden" name="userID" value="{{ $user['userID'] }}"></input>
								<input type="submit" class="btn btn-dark" name="delete" value="Delete"/>
							</form>
							</div>
    					</div>
    				</div>			
				</div>
		@endforeach
	</div>
</body>
@endsection