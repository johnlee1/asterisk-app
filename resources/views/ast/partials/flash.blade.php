@if (Session::has('astMessage'))
	<div class="alert alert-success">
		{!! Session::get('astMessage') !!}
	</div>
@endif