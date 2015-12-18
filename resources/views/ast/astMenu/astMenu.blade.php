@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
	
		<div class="astImageCenter" align="center">
			<img border="0" src={!!asset("astLogo.jpeg")!!} alt="TWR" width=200 height=173>
		</div>
	        
		<br>
	
		<hr/>
		
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<form action={!! route('phones', 'Clear') !!}><input type="submit" value="Phones" class="btn btn-default btn-lg btn-block"></form>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<form action={!! route('templates', 'Clear') !!}><input type="submit" value="Templates" class="btn btn-default btn-lg btn-block"></form>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<form action={!! route('parameters', 'Clear') !!}><input type="submit" value="Parameters" class="btn btn-default btn-lg btn-block"></form>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<form action={!! route('models', 'Clear') !!}><input type="submit" value="Models" class="btn btn-default btn-lg btn-block"></form>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<form action={!! route('locations', 'Clear') !!}><input type="submit" value="Locations" class="btn btn-default btn-lg btn-block"></form>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<form action={!! route('about', 'Clear') !!}><input type="submit" value="About" class="btn btn-default btn-lg btn-block"></form>
			</div>
		</div>
		
	</div>
	
@stop
