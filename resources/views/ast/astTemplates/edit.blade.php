@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
			
		<br>
		
		<h1 align="center">Edit Template</h1>
		
		<hr/>
		
		{!! Form::open(['method' => 'PATCH', 'route' => ['storeEditedTemplate', $astPhoneTemplate->PHONE_TEMPLATE_ID]]) !!}
	
	
			<div class="form-group">
				{!! Form::label('TEMPLATE_NAME', 'Template Name:') !!}
				{!! Form::text('TEMPLATE_NAME', $astPhoneTemplate->TEMPLATE_NAME, ['class' => 'form-control']) !!}
			</div>
			
		
			<div class="form-group">
				{!! Form::label('DESCRIPTION', 'Description:') !!}
				{!! Form::text('DESCRIPTION', $astPhoneTemplate->DESCRIPTION, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('TEMPLATE', 'Template:') !!}
				{!! Form::textarea('TEMPLATE', $astPhoneTemplate->TEMPLATE, ['class' => 'form-control']) !!}
			</div>
			
			
			<br>
			
			
			<div class="form-group">
				{!! Form::submit('Submit Template', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
		
		{!! Form::close() !!}
		
		<br>
		
	</div>
	
@stop