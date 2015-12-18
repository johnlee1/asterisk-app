@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
		
		<br>
		
		<h1 align="center">Phone</h1>
		
		<hr/>
		
		<form class="form-horizontal">
		
		  <div class="form-group">
		    <label class="col-sm-2 control-label"><b>Mac:</b></label>
		    <div class="col-sm-10">
		      <p class="form-control-static">{!! $astPhone->MAC !!}</p>
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <label class="col-sm-2 control-label"><b>Phone Template:</b></label>
		    <div class="col-sm-10">
		      <p class="form-control-static">{!! $astPhoneTemplateDescription !!}</p>
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <label class="col-sm-2 control-label"><b>Description:</b></label>
		    <div class="col-sm-10">
		      <p class="form-control-static">{!! $astPhone->DESCRIPTION !!}</p>
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <label class="col-sm-2 control-label"><b>Brand/Model:</b></label>
		    <div class="col-sm-10">
		      <p class="form-control-static">{!! $astBrandModelTypes[$astPhone->PHONE_MODEL_ID] !!}</p>
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <label class="col-sm-2 control-label"><b>Location:</b></label>
		    <div class="col-sm-10">
		      <p class="form-control-static">{!! $astPhone->phoneLocation->PHONE_LOCATION_NAME !!}</p>
		    </div>
		  </div>
		  
		</form>	
		
		
		<br>
		<br>
			
			
		{!! Form::open(['method' => 'PATCH', 'route' => ['storeEditedPhoneParameters', $astPhone->PHONE_ID]]) !!}
			
			
			<h1 align="center">Edit Phone Parameters</h1>
			
			<hr/>
			
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
								{!! Form::text($parameter->NAME, $astPhoneParameters[$parameter->NAME], ['class' => 'form-control']) !!}
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
								{!! Form::text($parameter->NAME, ' ', ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
				
				@endif
				
			@endforeach
						
			
			<div class="form-group">
				{!! Form::submit('Submit Changes', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
			<br>
			
		
		{!! Form::close() !!}
		
		
	</div>
	
@stop