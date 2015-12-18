@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		@include('ast.partials.flash')
		@include('ast.partials.unsuccessful')
		
		
		<br>
						
		<br>
				
		
		<h1>Users</h1>
		
				
		<hr>
		
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
		  <li role="presentation" class="active"><a href="#approvedUsers" aria-controls="approvedUsers" role="tab" data-toggle="tab">Approved Users</a></li>
		  <li role="presentation"><a href="#unapprovedUsers" aria-controls="unapprovedUsers" role="tab" data-toggle="tab">Unapproved Users</a></li>
		</ul>
		
		<div class="tab-content">
		
    		<div role="tabpanel" class="tab-pane active" id="approvedUsers">
    		
    		    {!! Form::open(['route' => 'disapproveUsers']) !!}
    		
    				@if (count($approvedUsers) > 0) 
    				
    					<br>
		
						<table class="table-striped">
						
							<tr>
								<th>Email</th>
								<th>Name</th>
							</tr>
										
							@foreach ($approvedUsers as $user)
							
								<tr>
									<td class="astSpacingRight">{!! Form::checkbox('email[]', $user->id) !!}{!! $user->email !!}</td>
									<td class="astSpacingRight">{!! $user->name !!}</td>
								</tr>
								
							@endforeach
							
						</table>
						
					@endif
						
						
					@if (count($approvedUsers) < 1) 
						<br>
						There are no approved users.
					@endif
					
					<br><br>
					
					{!! Form::submit('Disapprove Users', ['class' => 'btn btn-primary form-control']) !!}
					
				{!! Form::close() !!}
				    		
    		</div>
    		
    		<div role="tabpanel" class="tab-pane" id="unapprovedUsers">
    		
    			{!! Form::open(['route' => 'approveUsers']) !!}
    		
	    			@if (count($unapprovedUsers) > 0) 
	    			
	    				<br>
			
						<table class="table-striped">
						
							<tr>
								<th>Email</th>
								<th>Name</th>
							</tr>
											
							@foreach ($unapprovedUsers as $user)
								
								<tr>
									<td class="astSpacingRight">{!! Form::checkbox('email[]', $user->id) !!}{!! $user->email !!}</td>
									<td class="astSpacingRight">{!! $user->name !!}</td>
								</tr>
									
							@endforeach
								
						</table>
							
					@endif
							
							
					@if (count($unapprovedUsers) < 1) 
						<br>
						There are no unapproved users.
					@endif
					
					<br><br>
					
					{!! Form::submit('Approve Users', ['class' => 'btn btn-primary form-control']) !!}
					
				{!! Form::close() !!}
						
    		</div>
    		
  		</div>
		
		<hr>			
		
	</div>
	
@stop