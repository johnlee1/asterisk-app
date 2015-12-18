@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.flash')
		
		<br>
				
		<div class="row">
			<div class="col-md-4 col-md-offset-8">
				<form action={!! route('createTemplate', 'Clear') !!}><input type="submit" value="Add Template" class="btn btn-default btn-lg btn-block"></form>
			</div>
		</div>
		
		<h1>Templates</h1>
		
				
		<hr>
		
		<table class="table-striped">
		
			<tr>
				<th>Description</th>
			</tr>
						
			@foreach ($astTemplates as $astTemplate)
			
				<tr>
					<td class="astSpacingRight">{!! HTML::linkroute('showTemplate', $astTemplate->TEMPLATE_NAME, array($astTemplate->PHONE_TEMPLATE_ID)) !!}</td>
				</tr>
				
			@endforeach
			
		</table>

		<hr>
		
	</div>
	
@stop