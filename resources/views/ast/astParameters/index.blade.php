@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.flash')
		
		<br>
				
		<div class="row">
			<div class="col-md-4 col-md-offset-8">
				<form action={!! route('createParameter', 'Clear') !!}><input type="submit" value="Add Parameter" class="btn btn-default btn-lg btn-block"></form>
			</div>
		</div>
		
		<h1>Parameters</h1>
		
				
		<hr>
		
		<table class="table-striped">
		
			<tr>
				<th>Name</th>
			</tr>
						
			@foreach ($astParameters as $astParameter)
			
				<tr>
					<td class="astSpacingRight">{!! HTML::linkroute('showParameter', $astParameter->NAME, array($astParameter->PARAMETER_ID)) !!}</td>
				</tr>
				
			@endforeach
			
		</table>

		<hr>
		
	</div>
	
@stop