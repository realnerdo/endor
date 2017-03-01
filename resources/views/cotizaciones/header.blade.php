<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Header</title>
	<link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond" rel="stylesheet">
	<style>
		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		.header{
			clear: both;
			content: '';
			display: table;
			font-family: 'Cormorant Garamond', serif;
			padding: 0 3rem 0 5rem;
			width: 100%;
		}
		.header .logo{
			float: left;
			width: 50%;
		}
		.header .info{
			color: #939598;
			float: left;
			font-size: 14px;
			text-align: right;
			width: 50%;
		}
	</style>
</head>
<body>
	<header class="header">
	    <div class="logo">
	    	@if($setting->logo->url)
	        	<img src="{{ asset('storage/'.$setting->logo->url) }}" alt="Endor">
	        @else
	        	<img src="{{ asset('img/logo_black.svg') }}" alt="Endor">
	        @endif
	    </div><!-- /.logo -->
	    <div class="info">
	        <div class="folio">Folio: {{ $estimate->folio }}</div><!-- /.folio -->
	        <div class="location">Mérida, Yucatán</div><!-- /.location -->
	    </div><!-- /.info -->
	</header><!-- /.header -->
</body>
</html>