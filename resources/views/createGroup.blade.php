@extends('layouts.app')
@section('title', 'Create Group')
@section('content')
@guest
	<h2 style="text-align: center">Please login first!</h2>
@else
<body>
	<div>
		<form action="{{ action('UserController@createGroup') }}" method="post">
			{{ csrf_field() }}
			<div align="center">
				<table>
					<tr>
						<td>Name:</td>
						<td><input type="text" id="name" name="name"  placeholder="Name of the group"/></td>
					</tr>
					<tr>
						<td>Description:</td>
						<td><textarea id="description" name="description" placeholder="About the group"></textarea></td>
					</tr>
					<tr>
						<td colspan ="2" align="center">
							<input type="submit" value="Apply"/>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</div>
</body>
@endguest
@endsection