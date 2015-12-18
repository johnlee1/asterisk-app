@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
		
		<br>
		
		<h1 align="center">Add Location</h1>
		
		<hr/>
		
		{!! Form::open(['route' => 'locations']) !!}
		
			<div class="form-group">
				{!! Form::label('PHONE_LOCATION_NAME', 'Name:') !!}
				{!! Form::text('PHONE_LOCATION_NAME', null, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('SERVER_IP', 'Server IP:') !!}
				{!! Form::text('SERVER_IP', null, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('TFTP_DIRECTORY', 'TFTP Directory:') !!}
				{!! Form::text('TFTP_DIRECTORY', null, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('NON_TFTP_DIRECTORY', 'Non-TFTP Directory:') !!}
				{!! Form::text('NON_TFTP_DIRECTORY', null, ['class' => 'form-control']) !!}
			</div>
			
			
			<br>
			
			
			<div class="form-group">
				{!! Form::submit('Submit Location', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
		
		{!! Form::close() !!}
		
		<br>
		
	</div>
	
@stop