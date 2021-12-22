<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Declare Title, Content, Author
$pgAuthor = "David Sangrey";
$pgContent = "Contact the Hull Seals";
$useIP = 0; //1 if Yes, 0 if No.
$activePage = 'contact'; //Used only for Menu Bar Sites

//If you have any custom scripts, CSS, etc, you MUST declare them here.
//They will be inserted at the bottom of the <head> section.
//$customContent = '<!-- Test Comment mid US -->';

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>
                      <h1>Contact the Hull Seals</h1>
                <p>Thank you for your interest in reaching out to the Hull Seals.
                <br />
                There are many methods of contacting us, depending on what your needs are.
                <br />
                <br />
                <strong>Social</strong> - Join our community, or Join the Seals!
                <br />
                Want to join, or talk with our on-duty seals? Jump in our <a href="https://client.hullseals.space/" class="btn btn-dark btn-sm">IRC Chat</a><br />
                <br />
                <strong>CyberSeals</strong> - Our Tech Workers.
                <br />
                Contact us via <a href="mailto:cyberseals@hullseals.space" class="btn btn-info btn-sm">Email</a><br />
                <br />
                <strong>Publicity</strong> - Need to contact the Seals? Here's how!
                <br />
                Want to contact our team? The best way to contact us is by our <a href="mailto:hspublicity@hullseals.space" class="btn btn-info btn-sm">Email</a><br />
                <br />
                <strong>Administration</strong> - Anything regarding the running or organization of the Seals.
                <br />
                Need to contact our admins? Please send us an <a href="mailto:administration@hullseals.space" class="btn btn-info btn-sm">Email</a><br />
                <br />
                <strong>Don't see what you need?</strong> <br> Use our Publicity Email and get in touch!
              </p>
<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
