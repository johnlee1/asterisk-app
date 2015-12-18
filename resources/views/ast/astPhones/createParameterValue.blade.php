@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
		
		<br>
				
		<hr/>
		
		<h1 align="center">Create Phone Parameters</h1>
				
		
		<hr/>	
		
			
		{!! Form::open(['route' => ['createPhoneParameters', $astPhone->PHONE_ID]]) !!}
			
			@foreach ($fullParametersArray as $parameter)								
				
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
								{!! Form::text($parameter->NAME, null, ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
								
			@endforeach
			
			<br>
			<hr/>
			
			
			<div class="form-group">
				{!! Form::submit('Add Phone Parameters', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
		
		{!! Form::close() !!}
		
		<br>
		
	</div>
	
@stop