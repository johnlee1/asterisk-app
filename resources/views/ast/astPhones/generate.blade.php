@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.flash')
		@include('ast.partials.unsuccessful')
		
		
		<br>
			
		
		@if (Session::has('message'))
   			<div class="alert alert-info">{{ Session::get('message') }}</div>
		@endif
					
							
		<h1 align="center">{!! $astPhone->phoneModel->PSN . '-' . $astPhone->MAC . '.cnf.xml' !!}</h1>
				
		
		<hr/>	
		
			
		{!! Form::open(['route' => ['downloadXML', $astPhone->PHONE_ID]]) !!}
		
		
			<div class="form-group">
				{!! Form::label('template', 'XML:') !!}
				{!! Form::textarea('template', $template, ['class' => 'form-control']) !!}
			</div>
			
			<br>
			
			<div class="form-group">
				{!! Form::submit('Download XML', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			
		
		{!! Form::close() !!}
		
		
		{!! Form::open(['route' => ['transferXML', $astPhone->PHONE_ID]]) !!}
			
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-success form-control" data-toggle="modal" data-target="#myModal">
				Auto-Push XML File
			</button>
			
			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">XML File Transfer</h4> {!! $astPhone->phoneLocation->PHONE_LOCATION_NAME !!} {!! $astPhone->phoneLocation->SERVER_IP !!}
			        @if ($astPhone->phoneModel->USE_TFTP_DIR)
			        	{!! $astPhone->phoneLocation->TFTP_DIRECTORY !!}
			        @else
			        	{!! $astPhone->phoneLocation->NON_TFTP_DIRECTORY !!}
			        @endif      
			      </div>
			      <div class="modal-body">
			      	Please insert your username and password for server access. <br><br>
			        <div class="input-group">
			        	{!! Form::text('serverUsername', '', ['class' => 'form-control', 'placeholder' => 'Username', 'aria-describedby' => 'basic-addon1']) !!}			        
					</div>
			        <div class="input-group">
			        	{!! Form::password('serverPassword', ['class' => 'form-control', 'placeholder' => 'Password', 'aria-describedby' => 'basic-addon1']) !!}			        
			        </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
			      </div>
			    </div>
			  </div>
			</div>
		
		{!! Form::close() !!}
		
		
		<!-- this form is for overwrite -->
		
		@if ($overwrite == true)
						
				<!-- Modal -->
				<div class="modal show" id="overwrite" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h4 class="modal-title" id="myModalLabel">XML File Transfer</h4>
				      </div>
				      <div class="modal-body">
				      	A file with the same name already exists, are you sure you want to overwrite? <br><br>
				      	{!! Form::open(['route' => ['transferXMLOverwrite', $astPhone->PHONE_ID]]) !!}    	
					        {!! Form::submit('Overwrite the File', ['class' => 'btn btn-primary']) !!}
					    {!! Form::close() !!}
				      </div>
				      <div class="modal-footer">
					      	{!! Form::open(['method' => 'GET', 'route' => ['generateXML', $astPhone->PHONE_ID]]) !!}
					     		{!! Form::submit('Close', ['class' => 'btn btn-default']) !!}
					     	{!! Form::close() !!}
				      </div>
				    </div>
				  </div>
				</div>
			
		@endif 
		
		
		<br>
		
	</div>
	
@stop
