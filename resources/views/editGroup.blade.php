@extends('layouts.app')
@section('title', 'Edit Group')
@section('content')
<body>
	<div>
		<form action="{{ action('UserController@updateGroup') }}" method="post">
			{{ csrf_field() }}
			<input type="hidden" name="groupID" id="groupID" value="{{ $data['groupID'] }}"/>
			<div align="center">
				<table>
					<tr>
						<td>Name:</td>
						<td><input type="text" id="name" name="name"  value="{{ $data['name'] }}" placeholder="Name of the group"/></td>
					</tr>
					<tr>
						<td>Description:</td>
						<td><textarea id="description" name="description" placeholder="About the group">{{ $data['description'] }}</textarea></td>
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
@endsection