<html>

{!! HTML::style('css/bootstrap.css'); !!}
{!! HTML::style('css/common.css'); !!}

<head>

<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>	

	<script src="/js/bootstrap.js"></script>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />

	<script type="text/javascript">
	    var datefield=document.createElement("input")
	    datefield.setAttribute("type", "date")
	    if (datefield.type!="date"){ //if browser doesn't support input type="date", load files for jQuery UI Date Picker
    	    document.write('<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n')
    	    document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"><\/script>\n')
   	     document.write('<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"><\/script>\n')
  	  }
	</script>

	<!-- flash messaging -->
	<script>
		$(document).ready(function(){
		$('div.alert-success').delay(5000).slideUp(1000);
		});
	</script>
	<script>
                $(document).ready(function(){
                $('div.alert-warning').delay(5000).slideUp(1000);
                });
        </script>

	
	@yield('navBar')
	
</head>

@yield('appHeader')

<body>
	<div class="container">
		@if($errors->any())
			<ul class="alert alert-danger">
			@foreach( $errors->all() as $errorMsg )
				<li>{!! $errorMsg !!}</li>
			@endforeach
			</ul>
		@elseif (Session::has('message') and Session::get('message') <> '')
			<div class="alert alert-success">
			{!! Session::get('message') !!}
			</div>
		@endif
		@yield('content')
	</div>
</body>
</html>
