<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Declare Title, Content, Author
$pgAuthor = "David Sangrey";
$pgContent = "403 Error";
$useIP = 0; //1 if Yes, 0 if No.

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (!securePage($_SERVER['PHP_SELF'])) {
    die();
}
?>
<h1>403</h1>
<h5>That's an Error.</h5>
<hr>
<p>You don't have permission to view this page. <br /> If you feel this page was served in error, please let a Cyberseal know.</p>
<img src="https://http.cat/403" class="centerMyImages" alt="403 Error Cat">
<sub>Image Credit: <a href="https://http.cat" target="_blank">http.cat</a></sub>

<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
