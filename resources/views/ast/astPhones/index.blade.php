@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.flash')
		@include('ast.partials.unsuccessful')
		
		
		<br>
		
		
		<div class="col-md-8">
				
		{!! Form::open(['route' => 'phonesFilter']) !!}
		
			<table>
				<tr>
					<td>{!! Form::label('MAC', 'Mac:') !!}</td>
					<td><p>&nbsp;</p></td>
					<td><p>&nbsp;</p></td>
					<td>{!! Form::text('MAC', null) !!}  </td>
				</tr>	
				<tr>
					<td>{!! Form::label('DESCRIPTION', 'Description:') !!}</td>
					<td><p>&nbsp;</p></td>
					<td><p>&nbsp;</p></td>
					<td>{!! Form::text('DESCRIPTION', null) !!}  </td>
				</tr>	
			</table>			

			
			<br>
			

			{!! Form::submit('Filter', ['class' => 'btn btn-default']) !!}

					
		{!! Form::close() !!}
	
		
		<br>
		<hr/>
		
		
		<h1>Phones</h1>
		
				
		<hr>
		
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
					<td class="astSpacingRight">{!! HTML::linkroute('showPhone', $astPhone->MAC, array($astPhone->PHONE_ID)) !!}</td>
					<td class="astSpacingRight">{!! $astPhone->phoneModel->MODEL_NAME !!}</td>
					<td class="astSpacingRight">{!! $astPhone->phoneLocation->PHONE_LOCATION_NAME !!}</td>
					<td class="astSpacingRight">{!! $astPhone->DESCRIPTION !!}</td>
				</tr>
				
			@endforeach
			
		</table>
		
		@endif
		
		
		@if (count($astPhones) == 0) 
			There are no phones that match your criteria.
		@endif

		<hr>
		
		</div>
				
		<div class="col-md-4">
				
			<div class="row">
				<div class="col-md-8 col-md-offset-4">
					<form action={!! route('createPhone', 'Clear') !!}><input type="submit" value="Add Phone" class="btn btn-default btn-lg btn-block"></form>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-8 col-md-offset-4">
					<form action={!! route('importCSV', 'Clear') !!}><input type="submit" value="Import CSV" class="btn btn-default btn-lg btn-block"></form>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-8 col-md-offset-4">
					<form action={!! route('exportCSV', 'Clear') !!}><input type="submit" value="Export CSV" class="btn btn-default btn-lg btn-block"></form>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-8 col-md-offset-4">
					<form action={!! route('showMultipleXMLForAutopush', 'Clear', [true]) !!}><input type="submit" value="Autopush XML Files" class="btn btn-default btn-lg btn-block"></form>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-8 col-md-offset-4">
					<form action={!! route('showMultipleXML', 'Clear') !!}><input type="submit" value="Download XML Files" class="btn btn-default btn-lg btn-block"></form>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-8 col-md-offset-4">
					<form action={!! route('showMultiplePhones', 'Clear') !!}><input type="submit" value="Delete Phones" class="btn btn-default btn-lg btn-block"></form>
				</div>
			</div>
		
		</div>
		
	</div>
	
@stop