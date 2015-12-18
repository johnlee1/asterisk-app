@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
		
		<br>
		
		<h1 align="center">Edit Location</h1>
		
		<hr/>
		
		{!! Form::open(['method' => 'PATCH', 'route' => ['storeEditedLocation', $location->PHONE_LOCATION_ID]]) !!}
		
			<div class="form-group">
				{!! Form::label('NAME', 'Name:') !!}
				{!! Form::text('NAME', $location->PHONE_LOCATION_NAME, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('SERVER_IP', 'Server Ip:') !!}
				{!! Form::text('SERVER_IP', $location->SERVER_IP, ['class' => 'form-control']) !!}
			</div>
			
			<div class="form-group">
				{!! Form::label('TFTP_DIRECTORY', 'TFTP Dir:') !!}
				{!! Form::text('TFTP_DIRECTORY', $location->TFTP_DIRECTORY, ['class' => 'form-control']) !!}
			</div>
			
			<div class="form-group">
				{!! Form::label('NON_TFTP_DIRECTORY', 'NonTFTP Dir:') !!}
				{!! Form::text('NON_TFTP_DIRECTORY', $location->NON_TFTP_DIRECTORY, ['class' => 'form-control']) !!}
			</div>
			
			
			<br>
			
			
			<div class="form-group">
				{!! Form::submit('Update Location', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
		
		{!! Form::close() !!}
		
		<br>
		
	</div>
	
@stop