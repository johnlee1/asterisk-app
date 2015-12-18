@extends('twrAppLayout')


@section('appHeader')

	<!-- navigation bar -->
	
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="/asteriskPhone/index">The Asterisk App</a>
	    </div>
	
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
	        	<li>{!! HTML::linkroute('phones', 'Phones') !!}</li>
	        	<li>{!! HTML::linkroute('templates', 'Templates') !!}</li>
	        	<li>{!! HTML::linkroute('parameters', 'Parameters') !!}</li>
	        	<li>{!! HTML::linkroute('models', 'Models') !!}</li>
	        	<li>{!! HTML::linkroute('locations', 'Locations') !!}</li>
	        	<li>{!! HTML::linkroute('about', 'About') !!}</li>
	      	</ul>
	      

		<ul class="nav navbar-nav navbar-right">
  			@if (Auth::guest())
   			 	<li><a href="/auth/login">Login</a></li>
  			@else
  			  <li class="dropdown">
    			  	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
      			  	<ul class="dropdown-menu" role="menu">
                                        @if (Auth::user()->admin == 1)
                                                <li><a href="/users">Users</a></li>
                                        @endif
       			 	
					<li><a href="/auth/logout">Logout</a></li>
     			 	</ul>
  			  </li>
 		        @endif
		</ul>

	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	
@stop
