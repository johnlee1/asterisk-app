@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.flash')
		
		<br>
				
		<div class="row">
			<div class="col-md-4 col-md-offset-8">
				<form action={!! route('createLocation', 'Clear') !!}><input type="submit" value="Add Location" class="btn btn-default btn-lg btn-block"></form>
			</div>
		</div>
		
		<h1>Locations</h1>
		
				
		<hr>
		
		<table class="table-striped">
		
			<tr>
				<th>Name</th>
			</tr>
						
			@foreach ($astLocations as $astLocation)
			
				<tr>
					<td class="astSpacingRight">{!! HTML::linkroute('showLocation', $astLocation->PHONE_LOCATION_NAME, [$astLocation->PHONE_LOCATION_ID]) !!}</td>
				</tr>
				
			@endforeach
			
		</table>

		<hr>
		
	</div>
	
@stop