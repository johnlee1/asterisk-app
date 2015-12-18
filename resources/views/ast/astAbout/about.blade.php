@extends('ast/astLayout')

@section('content')

	<br>
	<br>

	<div class="container">
		
		<br>
		
		<h1 align="center">The Asterisk App</h1>
		
		<hr/>
		
		<p>The Asterisk App was created in the summer of 2015 in order to help better manage phone systems.</p>
		
		<br>
		
		<p>
		Some quick notes on this application: <br>
		- A phone can only be imported through an existing CSV if the template, model, and location exist for the phone. In addition, the MAC of the phone must be unique.<br>
		- Currently, the CSV file must have the columns: "template", "output", "_ignoreLocation", _"FIRST-LAST_", and "_LINE-LABEL1_".
		</p>
				
		<br>
		<br>

		Copyright 2015 John Lee<br>
		under GNU GPL v3 license
			
		
	</div>
	
@stop
