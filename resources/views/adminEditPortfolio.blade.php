@extends('layouts.app')
@section('title', 'Admin Edit Profile Page')
@section('content')
<body>
	<div>
		<form action="{{ action('UserController@adminUpdatePortfolio') }}" method="post">
			{{ csrf_field() }}
			<input type="hidden" id="userID" name="userID" value="{{ $data['userID'] }}"/>
			<div align="center">
				<table>
					<tr>
						<td>Job:</td>
						<td><input type="text" id="job" name="job" value="{{ $data['job'] }}"placeholder="Job"/></td>
					</tr>
					<tr>
						<td>Skill:</td>
						<td><input type="text" id="skills" name="skills" value="{{ $data['skills'] }}"placeholder="Skill"/></td>
					</tr>
					<tr>
						<td>Education:</td>
						<td><input type="text" id="education" name="education" value="{{ $data['education'] }}" placeholder="Education"/></td>
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