@if (Session::has('astDeleteMessage'))
	<div class="alert alert-warning">
		{!! Session::get('astDeleteMessage') !!}
	</div>
@endif