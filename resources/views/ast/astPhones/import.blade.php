@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.unsuccessful')
		
		{!! Form::open(['route'=>array('importPhones'),'files'=>true]) !!}
		
			{!! Form::label('selectlabel', 'Select a .csv file to import:') !!}
			{!! Form::file('importfile') !!}
			
			<hr>
			
			{!! Form::submit('Import', ['class'=>'btn btn-primary']) !!}
		
		{!! Form::close() !!}
		
	</div>
	
@stop
