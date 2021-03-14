@extends('layouts.app')
@section('title', 'View Job')
@section('content')
<style>
.table tr>td{
  padding-bottom: 2em;
  text-align: center;
  word-wrap: break-word;
}
</style>
<body>
	<div align="center">
		<table>
			<tr>
				<th>Name:</th>
				<td>{{ $data['name'] }}</td>
			</tr>
			<tr>
				<th>Email:</th>
				<td>{{ $data['email'] }}</td>
			</tr>
			<tr>
				<th>Job:</th>
				<td>{{ $data['job'] }}</td>
			</tr>
			<tr>
				<th>Skills:</th>
				<td>{{ $data['skills'] }}</td>
			</tr>
			<tr>
				<th>Education:</th>
				<td>{{ $data['education'] }}</td>
			</tr>
		</table>
	</div>
</body>
@endsection