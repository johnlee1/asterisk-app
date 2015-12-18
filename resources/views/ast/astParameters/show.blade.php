@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
		
		
		<br>
	
	
		{!! Form::open(['route' => ['editParameter', $parameter->PARAMETER_ID]]) !!}
			
			<div class="row">
				<div class="col-md-2 col-md-offset-10">
					{!! Form::submit('Edit Parameter', ['class' => 'btn btn-info form-control']) !!}
				</div>
			</div>
		
		{!! Form::close() !!}
		
		
	
		{!! Form::open(['method' => 'GET', 'route' => ['deleteParameter', $parameter->PARAMETER_ID]]) !!}
			
			@if (count($templates) == 0)
				<div class="row">
					<div class="col-md-2 col-md-offset-11">
						<button type="submit" href="{{ URL::route('deleteParameter', $parameter->PARAMETER_ID) }}" class="btn btn-danger btn-mini" onclick="if(!confirm('Are you sure you want to delete this parameter?')){return false;};">Delete</button>
					</div>
				</div>				
			@else
				<div class="row">
					<div class="col-md-2 col-md-offset-11">	
					
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-danger btn-mini" data-toggle="modal" data-target="#myModal">
							Delete
						</button>
						
						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel">Delete Parameter</h4>       
						      </div>
						      <div class="modal-body">
						      	Are you sure you want to delete this parameter? The following templates use this parameter: <br><br>
						      	@foreach ($templates as $template)
						      		{!! $template !!} <br>
						      	@endforeach
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default btn-mini" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Cancel</span></button>
						        <button type="submit" href="{{ URL::route('deleteParameter', $parameter->PARAMETER_ID) }}" class="btn btn-danger btn-mini">Delete</button>
						      </div>
						    </div>
						  </div>
						</div>
					</div>
				</div>			
			@endif
		
		{!! Form::close() !!}

		
		
		@if (Session::has('message'))
   			<div class="alert alert-info">{{ Session::get('message') }}</div>
		@endif
					
							
		<h1 align="center">Parameter Details</h1>
				
		
		<hr/>	
		
			
		{!! Form::open(['route' => ['storeEditedTemplate', $parameter->PARAMETER_ID]]) !!}
		
		
			<div class="form-group">
				{!! Form::label('NAME', 'Name:') !!}
				{!! Form::label('NAME', $parameter->NAME, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('Description', 'Description:') !!}
				{!! Form::label('Description', $parameter->DESCRIPTION, ['class' => 'form-control']) !!}
			</div>
			
			
			<br>
			
		
		{!! Form::close() !!}
		
		
		<br>
		<br>
		
	</div>
	
@stop
