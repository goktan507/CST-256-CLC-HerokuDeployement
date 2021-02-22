@extends('layouts.app')
@section('title', 'Portfolio')
@section('content')
<body>
	<div>
		<form action="{{ action('UserController@updatePortfolio') }}" method="post">
			{{ csrf_field() }}
			<div align="center">
				<table>
					<tr>
						<td>Job:</td>
						<td><input type="text" id="job" name="job" value="{{ $job }}" placeholder="Job"/></td>
					</tr>
					<tr>
						<td>skills:</td>
						<td><input type="text" id="skills" name="skills" value="{{ $skills }}" placeholder="Field of Interest"/></td>
					</tr>
					<tr>
						<td>Education:</td>
						<td><input type="text" id="education" name="education" value="{{ $education }}" placeholder="Field of Study"/></td>
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