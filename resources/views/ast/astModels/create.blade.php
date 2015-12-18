@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
		
		<br>
		
		<h1 align="center">Add Model</h1>
		
		<hr/>
		
		{!! Form::open(['route' => 'models']) !!}
		
			<div class="form-group">
				{!! Form::label('MODEL_NAME', 'Model Name:') !!}
				{!! Form::text('MODEL_NAME', null, ['class' => 'form-control']) !!}
			</div>
			
			<div class="form-group">
				{!! Form::label('PSN', 'PSN:') !!}
				{!! Form::text('PSN', null, ['class' => 'form-control']) !!}
			</div>
			
			<div class="form-group">
				{!! Form::label('BRAND', 'Brand:') !!}
				{!! Form::text('BRAND', null, ['class' => 'form-control']) !!}
			</div>
			
			<div class="form-group">
				{!! Form::label('USE_TFTP_DIR', 'Use TFTP Directory (1 or 0):') !!}
				{!! Form::text('USE_TFTP_DIR', null, ['class' => 'form-control']) !!}
			</div>

		
			<br>
			
			
			<div class="form-group">
				{!! Form::submit('Submit Model', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
		
		{!! Form::close() !!}
		
		<br>
		
	</div>
	
@stop
