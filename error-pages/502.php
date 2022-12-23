<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Declare Title, Content, Author
$pgAuthor = "David Sangrey";
$pgContent = "502 Error";
$useIP = 0; //1 if Yes, 0 if No.

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (!securePage($_SERVER['PHP_SELF'])) {
	die();
}
?>
<h1>502</h1>
<h5>That's an Error.</h5>
<hr>
<p>
	This means the server sent you either bad or incomplete data.<br />
	<em>Here's some things you can do:</em>
</p>
<ul>
	<li>Refresh the Page.</li>
	<li>Double Check your Link.</li>
	<li>Go Back and Try Again.</li>
	<li>Contact our Web Staff and inform them of the problem.</li>
</ul>
<img src="https://http.cat/502" class="centerMyImages" alt="502 Error Cat">
<sub>Image Credit: <a href="https://http.cat" target="_blank">http.cat</a></sub>

<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
