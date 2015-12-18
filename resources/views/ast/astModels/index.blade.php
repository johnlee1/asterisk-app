@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.flash')
		
		<br>
				
		<div class="row">
			<div class="col-md-4 col-md-offset-8">
				<form action={!! route('createModel', 'Clear') !!}><input type="submit" value="Add Model" class="btn btn-default btn-lg btn-block"></form>
			</div>
		</div>
		
		<h1>Models</h1>
		
				
		<hr>
		
		<table class="table-striped">
		
			<tr>
				<th>Model Name</th>
				<th>PSN</th>
				<th>Brand</th>
			</tr>
						
			@foreach ($astModels as $astModel)
			
				<tr>
					<td class="astSpacingRight">{!! HTML::linkroute('showModel', $astModel->MODEL_NAME, [$astModel->PHONE_MODEL_ID]) !!}</td>
					<td class="astSpacingRight">{!! $astModel->PSN !!}</td>
					<td class="astSpacingRight">{!! $astModel->BRAND !!}</td>

				</tr>
				
			@endforeach
			
		</table>

		<hr>
		
	</div>
	
@stop