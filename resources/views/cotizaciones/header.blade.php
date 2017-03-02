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
	    	<img src="{{ asset('img/logo_black.svg') }}" alt="Endor">
	    </div><!-- /.logo -->
	    <div class="info">
	        <div class="folio">Folio: {{ $estimate->folio }}</div><!-- /.folio -->
	        <div class="location">Mérida, Yucatán · {{ \Date::createFromFormat('Y-m-d H:i:s', $estimate->created_at)->format('j \\d\\e F Y') }}</div><!-- /.location -->
	    </div><!-- /.info -->
	</header><!-- /.header -->
</body>
</html>