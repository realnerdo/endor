<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Footer</title>
	<style>
		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		.footer{
			padding: 1rem 3rem 0 5rem;
			position: relative;
			text-align: right;
		}
		.footer .img{
			width: 20px;
		}
		.footer .line{
			position: absolute;
			top: 0;
			right: 3rem;
			background: #000;
			width: 25px;
			height: 1px;
		}
	</style>
</head>
<body>
	<footer class="footer">
		<div class="line"></div><!-- /.line -->
		<img src="{{ asset('img/quotes.png') }}" alt="Quotes" class="img">
	</footer><!-- /.footer -->
</body>
</html>