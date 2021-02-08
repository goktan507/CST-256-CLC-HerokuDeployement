@extends('layouts.app')
@section('title', 'Profile Page')
@section('content')
<body>
	<div>
		<form action="{{ action('UserController@updateUserProfile') }}" method="post">
			{{ csrf_field() }}
			<div align="center">
				<table>
					<tr>
						<td>Phone number:</td>
						<td><input type="text" id="phonenumber" name="phonenumber" value="{{ $phonenumber }}"placeholder="Phone Number"/></td>
					</tr>
					<tr>
						<td>Address:</td>
						<td><textarea id="address" name="address" rows="3" cols="50" placeholder="Your Address, Street number, Apartment no, etc.">{{ $address }}</textarea></td>
					</tr>
					<tr>
						<td>Biography (About yourself):</td>
						<td><textarea id="bigraphy" name="biography" rows="4" cols="50" placeholder="Biography, tell us about yourself.">{{ $biography }}</textarea></td>
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