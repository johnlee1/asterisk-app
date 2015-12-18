@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
			
		<br>
		
		<h1 align="center">Edit Model</h1>
		
		<hr/>
		
		{!! Form::open(['method' => 'PATCH', 'route' => ['storeEditedModel', $astPhoneModel->PHONE_MODEL_ID]]) !!}
		
			<div class="form-group">
				{!! Form::label('MODEL_NAME', 'Model Name:') !!}
				{!! Form::text('MODEL_NAME', $astPhoneModel->MODEL_NAME, ['class' => 'form-control']) !!}
			</div>
			
			<div class="form-group">
				{!! Form::label('PSN', 'PSN:') !!}
				{!! Form::text('PSN', $astPhoneModel->PSN, ['class' => 'form-control']) !!}
			</div>
			
			<div class="form-group">
				{!! Form::label('BRAND', 'Brand:') !!}
				{!! Form::text('BRAND', $astPhoneModel->BRAND, ['class' => 'form-control']) !!}
			</div>
			
			<div class="form-group">
				{!! Form::label('USE_TFTP_DIR', 'Use TFTP Directory (1 or 0):') !!}
				{!! Form::text('USE_TFTP_DIR', $astPhoneModel->USE_TFTP_DIR, ['class' => 'form-control']) !!}
			</div>
						
			
			<br>
			
			
			<div class="form-group">
				{!! Form::submit('Submit Model', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
		
		{!! Form::close() !!}
		
		<br>
		
	</div>
	
@stop
