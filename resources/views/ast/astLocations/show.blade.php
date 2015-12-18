@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
	
		@include('ast.partials.flashDelete')
		
		
		<br>
	
	
		{!! Form::open(['route' => ['editLocation', $location->PHONE_LOCATION_ID]]) !!}
			
			<div class="row">
				<div class="col-md-2 col-md-offset-10">
					{!! Form::submit('Edit Location', ['class' => 'btn btn-info form-control']) !!}
				</div>
			</div>
		
		{!! Form::close() !!}
		
		{!! Form::open(['method' => 'GET', 'route' => ['deleteLocation', $location->PHONE_LOCATION_ID]]) !!}
			
			<div class="row">
				<div class="col-md-2 col-md-offset-11">
					<button type="submit" href="{{ URL::route('deleteLocation', $location->PHONE_LOCATION_ID) }}" class="btn btn-danger btn-mini" onclick="if(!confirm('Are you sure you want to delete this location?')){return false;};">Delete</button>
				</div>
			</div>
		
		{!! Form::close() !!}
		
		
		@if (Session::has('message'))
   			<div class="alert alert-info">{{ Session::get('message') }}</div>
		@endif
					
							
		<h1 align="center">Location</h1>
				
		
		<hr/>	
		
			
		{!! Form::open(['route' => ['storeEditedTemplate', $location->PHONE_LOCATION_ID]]) !!}
		
		
			<div class="form-group">
				{!! Form::label('NAME', 'Name:') !!}
				{!! Form::label('NAME', $location->PHONE_LOCATION_NAME, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('SERVER_IP', 'Server Ip:') !!}
				{!! Form::label('SERVER_IP', $location->SERVER_IP, ['class' => 'form-control']) !!}
			</div>
			
			<div class="form-group">
				{!! Form::label('TFTP_DIR', 'TFTP Dir:') !!}
				{!! Form::label('TFTP_DIR', $location->TFTP_DIRECTORY, ['class' => 'form-control']) !!}
			</div>
			
			<div class="form-group">
				{!! Form::label('NONTFTP_DIR', 'NonTFTP Dir:') !!}
				{!! Form::label('NONTFTP_DIR', $location->NON_TFTP_DIRECTORY, ['class' => 'form-control']) !!}
			</div>
			
			
			<br>
			
		
		{!! Form::close() !!}
		
		
		<br>
		<br>
		
	</div>
	
@stop
