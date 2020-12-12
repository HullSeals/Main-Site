<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta content="418 Error - The Hull Seals" name="description">
	<title>Fuel | The Hull Seals</title><?php include '../assets/includes/headerCenter.php'; ?>
</head>
<body>
	<div id="home">
		<?php include '../assets/includes/menuCode.php';?>
		<section class="introduction container">
			<article id="intro3">
				<h1>418</h1>
				<h5>I'm a Teapot.</h5>
				<hr>
				<p>This server refuses to provide fuel rescues, because we are Hull Seals.<br>
				<br>
				Please attempt to connect to this page using HTCPCP in order to diagnose the issue.<br>
				<br>
				Looking for Fuel? Contact the <strong><a href="https://fuelrats.com" style="color: #FFFFFF;">Fuel Rats</a></strong></p>
			</article>
			<div class="clearfix"></div>
		</section>
	</div><?php include '../assets/includes/footer.php'; ?>
</body>
</html>
