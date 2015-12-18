@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.flash')
		@include('ast.partials.unsuccessful')
		
		
		<br>
	
	
		{!! Form::open(['route' => ['editPhone', $astPhone->PHONE_ID]]) !!}
			
			<div class="row">
				<div class="col-md-2 col-md-offset-10">
					{!! Form::submit('Edit Phone', ['class' => 'btn btn-info form-control']) !!}
				</div>
			</div>
		
		{!! Form::close() !!}
		
		
		{!! Form::open(['route' => ['copyPhone', $astPhone->PHONE_ID]]) !!}
			
			<div class="row">
				<div class="col-md-2 col-md-offset-10">
					{!! Form::submit('Copy Phone', ['class' => 'btn btn-info form-control']) !!}
				</div>
			</div>
		
		{!! Form::close() !!}
		
			
		{!! Form::open(['method' => 'GET', 'route' => ['generateXML', $astPhone->PHONE_ID]]) !!}
			
			<div class="row">
				<div class="col-md-2 col-md-offset-10">
					{!! Form::submit('Generate XML', ['class' => 'btn btn-warning form-control']) !!}
				</div>
			</div>
		
		{!! Form::close() !!}
		
		
		{!! Form::open(['method' => 'GET', 'route' => ['deletePhone', $astPhone->PHONE_ID]]) !!}
			
			<div class="row">
				<div class="col-md-2 col-md-offset-11">
					<button type="submit" href="{{ URL::route('deletePhone', $astPhone->PHONE_ID) }}" class="btn btn-danger btn-mini" onclick="if(!confirm('Are you sure you want to delete this phone?')){return false;};">Delete</button>
				</div>
			</div>
		
		{!! Form::close() !!}
		
		
		@if (Session::has('message'))
   			<div class="alert alert-info">{{ Session::get('message') }}</div>
		@endif
					
							
		<h1 align="center">Phone</h1>
				
		
		<hr/>	
		
			
		{!! Form::open(['route' => ['storeEditedPhone', $astPhone->PHONE_TEMPLATE_ID]]) !!}
		
		
			<div class="form-group">
				{!! Form::label('mac_Property', 'Mac:') !!}
				{!! Form::label('mac_Property', $astPhone->MAC, ['class' => 'form-control']) !!}
			</div>
			
		
			<div class="form-group">
				{!! Form::label('phoneTemplateProperty', 'Phone Template:') !!}
				{!! Form::label('phoneTemplateProperty', $astPhoneTemplateName, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('descriptionProperty', 'Description:') !!}
				{!! Form::label('descriptionProperty', $astPhone->DESCRIPTION, ['class' => 'form-control']) !!}
			</div>
			
		
			<div class="form-group">
				{!! Form::label('modelBrandProperty', 'Model/Brand:') !!}
				{!! Form::label('modelBrandProperty', $astPhoneModel, ['class' => 'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				{!! Form::label('location_Property', 'Location:') !!}
				{!! Form::label('location_Property', $astPhone->phoneLocation->PHONE_LOCATION_NAME, ['class' => 'form-control']) !!}
			</div>
			
			
			<br>
			
		
		{!! Form::close() !!}
		
		<br>
		
		<h1 align="center">Phone Parameters</h1>
				
		
		<hr/>	
		
			@if (count($astPhoneParameters) == 0)
				<div align="center">This phone currently has no displayable phone parameters. </div>
				<br><br>
			@endif
		
			@foreach ($fullParametersArray as $parameter)
						
				@if (array_key_exists($parameter->NAME, $astPhoneParameters))
					
					<div class="row">
						<div class="form-group">
							<div class="col-md-3">				
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								  <div class="panel panel-default">
								    <div class="panel-heading" role="tab" id="headingOne">
								      <h4 class="panel-title">
								        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{!!$parameter->NAME!!}" aria-expanded="true" aria-controls={!!$parameter->NAME!!}>
								          {!! $parameter->NAME !!}
								        </a>
								      </h4>
								    </div>
								    <div id={!!$parameter->NAME!!} class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
								      <div class="panel-body">
								      	{!! $parameter->DESCRIPTION !!}
								      </div>
								    </div>
								  </div>
								 </div>
							 </div>
							 <div class="col-md-9">				
								{!! Form::label($parameter->NAME, $astPhoneParameters[$parameter->NAME], ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
				
				@else
				
					<div class="row">
						<div class="form-group">
							<div class="col-md-3">				
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								  <div class="panel panel-default">
								    <div class="panel-heading" role="tab" id="headingOne">
								      <h4 class="panel-title">
								        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{!!$parameter->NAME!!}" aria-expanded="true" aria-controls={!!$parameter->NAME!!}>
								          {!! $parameter->NAME !!}
								        </a>
								      </h4>
								    </div>
								    <div id={!!$parameter->NAME!!} class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
								      <div class="panel-body">
								      	{!! $parameter->DESCRIPTION !!}
								      </div>
								    </div>
								  </div>
								 </div>
							 </div>
							 <div class="col-md-9">				
								{!! Form::label($parameter->NAME, ' ', ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
				
				@endif
				
			@endforeach
		
		<br>
		
	</div>
	
@stop
