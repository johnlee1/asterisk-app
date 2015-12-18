@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">

		@include('ast.partials.flashDelete')
		
		<br>
	
	
		{!! Form::open(['route' => ['editTemplate', $astTemplate->PHONE_TEMPLATE_ID]]) !!}
			
			<div class="row">
				<div class="col-md-2 col-md-offset-10">
					{!! Form::submit('Edit Template', ['class' => 'btn btn-info form-control']) !!}
				</div>
			</div>
		
		{!! Form::close() !!}
		
		
		{!! Form::open(['method' => 'GET', 'route' => ['deleteTemplate', $astTemplate->PHONE_TEMPLATE_ID]]) !!}
			
			<div class="row">
				<div class="col-md-2 col-md-offset-11">
					<button type="submit" href="{{ URL::route('deleteTemplate', $astTemplate->PHONE_TEMPLATE_ID) }}" class="btn btn-danger btn-mini" onclick="if(!confirm('Are you sure you want to delete this template?')){return false;};">Delete</button>
				</div>
			</div>
		
		{!! Form::close() !!}
		
		
		@if (Session::has('message'))
   			<div class="alert alert-info">{{ Session::get('message') }}</div>
		@endif
					
							
		<h1 align="center">Template Details</h1>
				
		
		<hr/>	
		
			
		{!! Form::open(['route' => ['storeEditedTemplate', $astTemplate->PHONE_TEMPLATE_ID]]) !!}
	
			<div class="form-group">
				{!! Form::label('TEMPLATE_NAME', 'Template Name:') !!}
				{!! Form::label('TEMPLATE_NAME', $astTemplate->TEMPLATE_NAME, ['class' => 'form-control']) !!}
			</div>	
		
			<div class="form-group">
				{!! Form::label('DESCRIPTION', 'Description:') !!}
				{!! Form::label('DESCRIPTION', $astTemplate->DESCRIPTION, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('Template', 'Template:') !!}
				{!! Form::textarea('Template', $astTemplate->TEMPLATE, ['class' => 'form-control']) !!}
			</div>
			
			
			<br>
			
		
		{!! Form::close() !!}
		
		
		<br>
		<br>
		
	</div>
	
@stop
