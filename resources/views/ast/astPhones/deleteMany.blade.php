@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.flash')
		
		<br>
		
		<h1 align="center"> Delete Phones </h1>
		
		<br>
		
				
		{!! Form::open(['route' => 'phonesDeleteFilter2']) !!}
		
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
		
		{!! Form::open(['method' => 'GET', 'route' => 'showMultiplePhones']) !!}
			{!! Form::submit('Unselect All Phones', ['class' => 'btn btn-default btn-xs']) !!}
		{!! Form::close() !!}
	
		<hr/>			
		
		{!! Form::open(['route' => 'deleteMultiplePhones']) !!}
		
		
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
			
			<button type="submit" class="btn btn-danger form-control" onclick="if(!confirm('Are you sure you want to delete phones?')){return false;};">Delete Phones</button>
			
<!-- 			{!! Form::submit('Delete Phones', ['class' => 'btn btn-danger form-control', 'onclick' => "if(!confirm('Are you sure you want to delete this phone?')){return false;};"]) !!} -->
		
		@endif
		
		
		@if (count($astPhones) == 0) 
			There are no phones that match your criteria.
		@endif

		<hr>		
		
		{!! Form::close() !!}
		
	</div>
	
@stop