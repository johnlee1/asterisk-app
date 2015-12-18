@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">

		@include('ast.partials.flashDelete')
		
		<br>
	
	
		{!! Form::open(['route' => ['editModel', $astModel->PHONE_MODEL_ID]]) !!}
			
			<div class="row">
				<div class="col-md-2 col-md-offset-10">
					{!! Form::submit('Edit Model', ['class' => 'btn btn-info form-control']) !!}
				</div>
			</div>
		
		{!! Form::close() !!}
		
		
		{!! Form::open(['method' => 'GET', 'route' => ['deleteModel', $astModel->PHONE_MODEL_ID]]) !!}
			
			<div class="row">
				<div class="col-md-2 col-md-offset-11">
					<button type="submit" href="{{ URL::route('deleteTemplate', $astModel->PHONE_MODEL_ID) }}" class="btn btn-danger btn-mini" onclick="if(!confirm('Are you sure you want to delete this model?')){return false;};">Delete</button>
				</div>
			</div>
		
		{!! Form::close() !!}
		
		
		@if (Session::has('message'))
   			<div class="alert alert-info">{{ Session::get('message') }}</div>
		@endif
					
							
		<h1 align="center">Model Details</h1>
				
		
		<hr/>	
		
			
		{!! Form::open() !!}
		
		
			<div class="form-group">
				{!! Form::label('MODEL_NAME', 'Model Name:') !!}
				{!! Form::label('MODEL_NAME', $astModel->MODEL_NAME, ['class' => 'form-control']) !!}
			</div>
			
			<div class="form-group">
				{!! Form::label('PSN', 'PSN:') !!}
				{!! Form::label('PSN', $astModel->PSN, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('BRAND', 'Brand:') !!}
				{!! Form::label('BRAND', $astModel->BRAND, ['class' => 'form-control']) !!}
			</div>
			
			@if ($astModel->USE_TFTP_DIR == 1)
				<div class="form-group">
					{!! Form::label('USE_TFTP_DIR', 'Use TFTP Directory:') !!}
					{!! Form::label('USE_TFTP_DIR', 'true', ['class' => 'form-control']) !!}
				</div>		
			@else
				<div class="form-group">
					{!! Form::label('USE_TFTP_DIR', 'Use TFTP Directory:') !!}
					{!! Form::label('USE_TFTP_DIR', 'false', ['class' => 'form-control']) !!}
				</div>		
			@endif

			
			<br>
			
		
		{!! Form::close() !!}
		
		
		<br>
		<br>
		
	</div>
	
@stop
