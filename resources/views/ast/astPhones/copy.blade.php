@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
		
		<br>
		
		@include('ast.partials.unsuccessful')
		
		<h1 align="center">Copy Phone</h1>
		
		<hr/>
		
		{!! Form::open(['method' => 'PATCH', 'route' => ['storeCopiedPhone', $astPhone->PHONE_ID]]) !!}
	
		
			<div class="form-group">
				{!! Form::label('MAC', 'Mac:') !!}
				{!! Form::text('MAC', $astPhone->MAC, ['class' => 'form-control']) !!}
			</div>
			
		
			<div class="form-group">
				{!! Form::label('PHONE_TEMPLATE_ID', 'Phone Template:') !!}
				{!! Form::select('PHONE_TEMPLATE_ID', $templateNames, $astPhone->PHONE_TEMPLATE_ID, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('DESCRIPTION', 'Description:') !!}
				{!! Form::text('DESCRIPTION', $astPhone->DESCRIPTION, ['class' => 'form-control']) !!}
			</div>

			
			<div class="form-group">
				{!! Form::label('PHONE_MODEL_ID', 'Brand/Model:') !!}
				{!! Form::select('PHONE_MODEL_ID', $astBrandModelTypes, $astPhone->PHONE_MODEL_ID, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('PHONE_LOCATION_ID', 'Location:') !!}
				{!! Form::select('PHONE_LOCATION_ID', $astLocationResponseTypes, $astPhone->PHONE_LOCATION_ID, ['class' => 'form-control']) !!}
			</div>
			

			<br>
			
			
			<div class="form-group">
				{!! Form::submit('Create New Phone and Edit Phone Parameters', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
		
		{!! Form::close() !!}
		
		
	</div>
	
@stop
