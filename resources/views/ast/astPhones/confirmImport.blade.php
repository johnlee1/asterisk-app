@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
				
			<h2>CSV File Imported!</h2>
			<br><br>
			
			<div>
			
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#importResults" aria-controls="importResults" role="tab" data-toggle="tab">Import Results</a></li>
			    <li role="presentation"><a href="#unknownParameters" aria-controls="unknownParameters" role="tab" data-toggle="tab">Unknown Parameters</a></li>
			  </ul>
			
			  <!-- Tab panes -->
			  <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="importResults">
			    
			    	<br><br><br>
			    
					<div class="leftColumnForImport">
						@if (count($importedPhones) > 0)
							The following phones were successfully imported:
							<br><br>
							<table class="table table-striped">
								@foreach ($importedPhones as $importedPhone)
									<tr><td>{!! $importedPhone !!} successfully imported from line {!! $successLineNumbers[$importedPhone] !!}</td></tr>
								@endforeach
							</table>
						@endif
					</div>
					
					<div class="rightColumnForImport">
						@if (count($failedPhones) > 0)
							The following phones could not be imported:
							<br><br>
							<table class="table table-striped">
								@foreach ($failedPhones as $failedPhone)
									<tr><td>{!! $failedPhone !!} from line {!! $failedLineNumbers[$failedPhone] !!} had an issue with {!! $failedParameters[$failedPhone] !!}</td></tr>
								@endforeach
							</table>
						@endif
						
						<br><br><br><br><br>
						
						{!! Form::open(['method' => 'get', 'route'=>'phones']) !!}
						
							{!! Form::submit('Ok', ['class'=>'btn btn-primary']) !!}
				
						{!! Form::close() !!}
					</div>
			    
			    </div>
			    <div role="tabpanel" class="tab-pane" id="unknownParameters">
			    
			    	<br><br><br>
			    
					<div class="leftColumnForImport">
						@if (count($unknownParameters) == 0)
							There were no unknown parameters.
						@else
							{!! Form::open(['method' => 'get', 'route'=>'newParameters']) !!}
								The following parameters were unknown:
								<br><br>
								<table class="table table-striped">
									@foreach ($unknownParametersNames as $unknownParameter)
										<tr><td>{!! Form::checkbox('unknownParameter[]', $unknownParameter, true) !!}&nbsp;{!! $unknownParameter !!}</td></tr>
									@endforeach
								</table>
							
								{!! Form::submit('Add Parameters to Database', ['class'=>'btn btn-primary']) !!}					
							{!! Form::close() !!}
							
						@endif
					</div>
					
					<div class="rightColumnForImport">
						
					</div>
			    
			    </div>
			  </div>
			
			</div>
					
	</div>
	
@stop
