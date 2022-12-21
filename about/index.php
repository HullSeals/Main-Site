<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Declare Title, Content, Author
$pgAuthor = "David Sangrey";
$pgContent = "About the Hull Seals";
$useIP = 0; //1 if Yes, 0 if No.

//If you have any custom scripts, CSS, etc, you MUST declare them here.
//They will be inserted at the bottom of the <head> section.
$customContent = '';

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (!securePage($_SERVER['PHP_SELF'])) {
  die();
}
?>
<h1>About the Hull Seals</h1>
<br />
<p>The Hull Seals are a group of enthusiasts supporting other players in odd situations within Elite Dangerous.
  <br />
  <br />
  We were founded in January of 3305, in preparation of the Distant Worlds 2 Expedition, an extension and elaboration of the existing Fleet Mechanics role. Many of us remembered the panic of a broken canopy or low hull percentage deep in the black with no plan or force to help.
  <br />
  <br />
  <em>But no more.</em> Enter the Hull Seals.
  <br />
  <br />
  We are a group of players dedicated to rescuing these ailing commanders out in the black. So, if you find yourself in need of hull repairs or have a broken canopy, don't hesitate to call! We have trained commanders all across the galaxy waiting to assist you.
  <br />
  <br />
  Don't risk it. Make the call.
  <br />
  <br />
  <a href="../repair-requests" class="btn btn-danger">I need repairs!</a>
  <br />
  <br />
  We'll see you out there, CMDR.
</p>
<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
