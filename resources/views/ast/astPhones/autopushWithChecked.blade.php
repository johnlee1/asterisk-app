@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.flash')
		
		<br>
		
		<h1 align="center"> Autopush XML Files </h1>
		<h5 align="center"> (must be of the same location) </h5>
		
		<br>
				
		{!! Form::open(['route' => 'autopushFilter']) !!}
		
			<table>
				<tr>
					<td>{!! Form::label('LOCATION', 'Location:') !!}</td>
					<td><p>&nbsp;</p></td>
					<td><p>&nbsp;</p></td>
					<td>{!! Form::select('LOCATION', [null=>'Please Select'] + $astLocationResponseTypes, ' ', ['class' => 'form-control']) !!}</td>
				</tr>
				<tr>
					<td>{!! Form::label('MAC', 'Mac:') !!}</td>
					<td><p>&nbsp;</p></td>
					<td><p>&nbsp;</p></td>
					<td>{!! Form::text('MAC', null) !!}  </td>
				</tr>	
			</table>			

			<br>
			
			{!! Form::submit('Filter', ['class' => 'btn btn-default']) !!}
			
		{!! Form::close() !!}
	
		
		<br>
		
		{!! Form::open(['method' => 'GET', 'route' => 'showManyXMLForAutopush']) !!}
			{!! Form::submit('Select All Phones', ['class' => 'btn btn-default btn-xs']) !!}
		{!! Form::close() !!}
	
		<hr/>		
			
		
		{!! Form::open(['route' => 'autopushMultipleXML']) !!}
		
		
		<h1>Phones</h1>
		
		<hr>
		
		<br>
		
		@if (count($astPhones) != 0) 
		
			<table class="table-striped">
			
				<tr>
					<th>Mac</th>
					<th>Model</th>
					<th>Location</th>
					<th>Description</th>
				</tr>
							
				@foreach ($astPhones as $astPhone)
				
					<tr>
						<td class="astSpacingRight">{!! Form::checkbox('MAC[]', $astPhone->MAC, true) !!}{!! $astPhone->MAC !!}</td>
						<td class="astSpacingRight">{!! $astPhone->phoneModel->MODEL_NAME !!}</td>
						<td class="astSpacingRight">{!! $astPhone->phoneLocation->PHONE_LOCATION_NAME !!}</td>
						<td class="astSpacingRight">{!! $astPhone->DESCRIPTION !!}</td>
					</tr>
					
				@endforeach
				
			</table>
			
			<br><br>
			
			{!! Form::submit('Autopush XML Files as Zip', ['class' => 'btn btn-primary form-control']) !!}
		
		@endif
		
		
		@if (count($astPhones) == 0) 
			There are no phones that match your criteria.
		@endif

		<hr>		
		
		{!! Form::close() !!}
		
	</div>
	
@stop