@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.flash')
		
		<br>
		
		<h1 align="center"> Download XML Files </h1>
		
		<br>
				
		{!! Form::open(['route' => 'phonesDownloadFilter']) !!}
		
			<table>
				<tr>
					<td>{!! Form::label('MAC', 'Mac:') !!}</td>
					<td>{!! Form::text('MAC', null) !!}  </td>
				</tr>	
			</table>			

			<br>
			
			{!! Form::submit('Filter', ['class' => 'btn btn-default']) !!}
			
		{!! Form::close() !!}
	
		
		<br>
		
		{!! Form::open(['method' => 'GET', 'route' => 'showManyXML']) !!}
			{!! Form::submit('Select All Phones', ['class' => 'btn btn-default btn-xs']) !!}
		{!! Form::close() !!}
	
		<hr/>		
			
		
		{!! Form::open(['route' => 'downloadMultipleXML']) !!}
		
		
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
						<td class="astSpacingRight">{!! Form::checkbox('MAC[]', $astPhone->MAC) !!}{!! $astPhone->MAC !!}</td>
						<td class="astSpacingRight">{!! $astPhone->phoneModel->MODEL_NAME !!}</td>
						<td class="astSpacingRight">{!! $astPhone->phoneLocation->PHONE_LOCATION_NAME !!}</td>
						<td class="astSpacingRight">{!! $astPhone->DESCRIPTION !!}</td>
					</tr>
					
				@endforeach
				
			</table>
			
			<br><br>
			
			{!! Form::submit('Download XML Files as Zip', ['class' => 'btn btn-primary form-control']) !!}
		
		@endif
		
		
		@if (count($astPhones) == 0) 
			There are no phones that match your criteria.
		@endif

		<hr>		
		
		{!! Form::close() !!}
		
	</div>
	
@stop