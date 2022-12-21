<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Declare Title, Content, Author
$pgAuthor = "David Sangrey";
$pgContent = "418 Error";
$useIP = 0; //1 if Yes, 0 if No.

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (!securePage($_SERVER['PHP_SELF'])) {
	die();
}
?>
<h1>418</h1>
<h5>I'm a Teapot.</h5>
<hr>
<p>
	This server refuses to provide fuel rescues, because we are Hull Seals.<br>
	<br>
	Please attempt to connect to this page using HTCPCP in order to diagnose the issue.<br>
	<br>
	Looking for Fuel? Contact the <strong><a href="https://fuelrats.com" style="color: #FFFFFF;">Fuel Rats</a></strong>
</p>
<img src="https://http.cat/418" class="centerMyImages" alt="418 Error Cat">
<sub>Image Credit: <a href="https://http.cat" target="_blank">http.cat</a></sub>

<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
