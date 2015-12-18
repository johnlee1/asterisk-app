@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
		
		<br>
		
		<h1 align="center">Add Parameter</h1>
		
		<hr/>
		
		{!! Form::open(['route' => 'parameters']) !!}
		
			<div class="form-group">
				{!! Form::label('NAME', 'Name:') !!}
				{!! Form::text('NAME', null, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('DESCRIPTION', 'Description:') !!}
				{!! Form::textarea('DESCRIPTION', null, ['class' => 'form-control']) !!}
			</div>
			
			
			<br>
			
			
			<div class="form-group">
				{!! Form::submit('Submit Parameter', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
		
		{!! Form::close() !!}
		
		<br>
		
	</div>
	
@stop