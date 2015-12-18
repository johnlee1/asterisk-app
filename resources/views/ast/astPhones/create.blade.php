@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.unsuccessful')
		
		<br>
		
		<h1 align="center">Add Phone</h1>
		
		<hr/>
		
		{!! Form::open(['route' => 'phones']) !!}
		
		
			<div class="form-group">
				{!! Form::label('MAC', 'Mac:') !!}
				{!! Form::text('MAC', null, ['class' => 'form-control']) !!}
			</div>
			
		
			<div class="form-group">
				{!! Form::label('PHONE_TEMPLATE_ID', 'Phone Template:') !!}
				{!! Form::select('PHONE_TEMPLATE_ID', $astResponseTypes, null, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('DESCRIPTION', 'Description:') !!}
				{!! Form::text('DESCRIPTION', null, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('PHONE_MODEL_ID', 'Brand/Model:') !!}
				{!! Form::select('PHONE_MODEL_ID', $astBrandModelTypes, null, ['class' => 'form-control']) !!}
			</div>


			<div class="form-group">
				{!! Form::label('PHONE_LOCATION_ID', 'Location:') !!}
				{!! Form::select('PHONE_LOCATION_ID', $astLocationResponseTypes, null, ['class' => 'form-control']) !!}
			</div>
			
			
			<br>
			
			
			<div class="form-group">
				{!! Form::submit('Add Parameters', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
		
		{!! Form::close() !!}
		
		<br>
		
	</div>
	
@stop