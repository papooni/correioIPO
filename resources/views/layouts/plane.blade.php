<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title>IPO</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	<link rel="shortcut icon" href="http://ipoporto.pt/wp-content/themes/IPO/ipoporto_ficon.png" />

	<link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />
	<!--<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">-->
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
	<style>
		html, body {
			height: 100%;
			width: 100%;
		}


		body {
			margin: 0;
			padding: 0;
			width: 100%;
			font-family: 'Roboto Condensed';
			font-weight:100;
			display: table;
			vertical-align: middle;
		}

		.container {
			text-align: center;

		}

		.content {
			text-align: center;
			display: inline-block;
		}

		.title {
			font-size: 90px;
		}
		a {
			text-decoration: none;
			color:black;
		}
		a:hover{
			text-decoration: none;
			color:black;
		}

	</style>
</head>
<body>
		<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
		@yield('body')
</body>
</html>