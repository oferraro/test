@extends('layout')

@section('content')
<h1>Login Section</h1>
<form method="post">
	<select name="user">
		<option value="1">User 1</option>
		<option value="2">User 2</option>
	</select> 
	<input type="submit">
</form>
@stop
