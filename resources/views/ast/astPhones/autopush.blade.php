@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.flash')
		@include('ast.partials.unsuccessful')
		
		<br>
		
		<h1 align="center"> Autopush XML Files </h1>
		<h5 align="center"> (must be of the same location) </h5>
		
		<br>
				
		{!! Form::open(['route' => 'autopushFilter']) !!}
		
			<table>
				<tr>
					<td>{!! Form::label('LOCATION', 'Location:') !!}</td>
					<td><p>&nbsp;</p></td>
					<td><p>&nbsp;</p></td>
					<td>{!! Form::select('LOCATION', [null=>'Please Select'] + $astLocationResponseTypes, ' ', ['class' => 'form-control']) !!}</td>
				</tr>
				<tr>
					<td>{!! Form::label('MAC', 'Mac:') !!}</td>
					<td><p>&nbsp;</p></td>
					<td><p>&nbsp;</p></td>
					<td>{!! Form::text('MAC', null) !!}  </td>
				</tr>	
			</table>			

			<br>
			
			{!! Form::submit('Filter', ['class' => 'btn btn-default']) !!}
			
		{!! Form::close() !!}
	
		
		<br>
		
		{!! Form::open(['method' => 'GET', 'route' => 'showManyXMLForAutopush']) !!}
			{!! Form::submit('Select All Phones', ['class' => 'btn btn-default btn-xs']) !!}
		{!! Form::close() !!}
	
		<hr/>		
			
		
		{!! Form::open(['route' => 'autopushMultipleXML']) !!}
		
		
		<h1>Phones</h1>
		
		<hr>
		
		<br>
		
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
						<td class="astSpacingRight">{!! Form::checkbox('MAC[]', $astPhone->MAC) !!}{!! $astPhone->MAC !!}</td>
						<td class="astSpacingRight">{!! $astPhone->phoneModel->MODEL_NAME !!}</td>
						<td class="astSpacingRight">{!! $astPhone->phoneLocation->PHONE_LOCATION_NAME !!}</td>
						<td class="astSpacingRight">{!! $astPhone->DESCRIPTION !!}</td>
					</tr>
					
				@endforeach
				
			</table>
			
			<br><br>
			
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#myModal">
				Auto-Push XML Files as Zip
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
			
<!-- 			{!! Form::submit('Autopush XML Files as Zip', ['class' => 'btn btn-primary form-control']) !!} -->
		
		@endif
		
		
		@if (count($astPhones) == 0) 
			There are no phones that match your criteria.
		@endif

		<hr>		
		
		{!! Form::close() !!}
		
	</div>
	
@stop