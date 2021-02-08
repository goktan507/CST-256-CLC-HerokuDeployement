@extends('layouts.app')
@section('title', 'Admin Edit Profile Page')
@section('content')
<body>
	<div>
		<form action="{{ action('UserController@adminUpdateSelectedProfile') }}" method="post">
			{{ csrf_field() }}
			<input type="hidden" id="userID" name="userID" value="{{ $data['userID'] }}"/>
			<div align="center">
				<table>
					<tr>
						<td>Name:</td>
						<td><input type="text" id="name" name="name" value="{{ $data['name'] }}"placeholder="Name"/></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><input type="text" id="email" name="email" value="{{ $data['email'] }}"placeholder="Email"/></td>
					</tr>
					<tr>
						<td>isAdmin:</td>
						<td><input type="text" id="isAdmin" name="isAdmin" value="{{ $data['isAdmin'] }}" placeholder="0 => Normal | 1 => Admin"/></td>
					</tr>
					<tr>
						<td>Biography (About yourself):</td>
						<td><textarea id="bigraphy" name="biography" rows="4" cols="50" placeholder="Biography, tell us about yourself.">{{ $data['biography'] }}</textarea></td>
					</tr>
					<tr>
						<td>Address:</td>
						<td><textarea id="address" name="address" rows="3" cols="50" placeholder="Your Address, Street number, Apartment no, etc.">{{ $data['address'] }}</textarea></td>
					</tr>
					<tr>
						<td>Phone Number: </td>
						<td><input type="text" id="phonenumber" name="phonenumber" value="{{ $data['phonenumber'] }}"placeholder="Phone Number (no letters, no spaces, no dashes)"/></td>
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