@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
		
		<br>
		
		<h1 align="center">Add Template</h1>
		
		<hr/>
		
		{!! Form::open(['route' => 'templates']) !!}

		
			<div class="form-group">
				{!! Form::label('TEMPLATE_NAME', 'Template Name:') !!}
				{!! Form::text('TEMPLATE_NAME', null, ['class' => 'form-control']) !!}
			</div>
			
		
			<div class="form-group">
				{!! Form::label('DESCRIPTION', 'Description:') !!}
				{!! Form::text('DESCRIPTION', null, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('TEMPLATE', 'Template:') !!}
				{!! Form::textarea('TEMPLATE', null, ['class' => 'form-control']) !!}
			</div>
			
			
			<br>
			
			
			<div class="form-group">
				{!! Form::submit('Submit Template', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
		
		{!! Form::close() !!}
		
		<br>
		
	</div>
	
@stop