@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
		
		<br>
		
		<h1 align="center">Edit Parameter Description</h1>
		
		<hr/>
		
		{!! Form::open(['method' => 'PATCH', 'route' => ['storeEditedParameter', $astParameter->PARAMETER_ID]]) !!}
		
			<div class="form-group">
				{!! Form::label('NAME', 'Name:') !!}
				{!! Form::label('NAME', $astParameter->NAME, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('DESCRIPTION', 'Description:') !!}
				{!! Form::textarea('DESCRIPTION', $astParameter->DESCRIPTION, ['class' => 'form-control']) !!}
			</div>
			
			
			<br>
			
			
			<div class="form-group">
				{!! Form::submit('Update Parameter', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
		
		{!! Form::close() !!}
		
		<br>
		
	</div>
	
@stop