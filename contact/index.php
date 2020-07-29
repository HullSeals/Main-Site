<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
if (!securePage($_SERVER['PHP_SELF'])){die();}

$activePage = 'contact';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="Contact the Hull Seals" name="description">
    <title>Contact | The Hull Seals</title>
    <?php include '../assets/includes/headerCenter.php'; ?>
</head>
<body>
    <div id="home">
      <?php include '../assets/includes/menuCode.php';?>
        <section class="introduction container">
	    <article id="intro3">
                <h1>Contact the Hull Seals</h1>
                <p>Thank you for your interest in reaching out to the Hull Seals.
                <br />
                There are many methods of contacting us, depending on what your needs are.
                <br />
                <br />
                <strong>Social</strong> - Join our community, or Join the Seals!
                <br />
                Want to join, or talk with our on-duty seals? Jump in our <a href="#" class="btn btn-dark btn-sm">IRC Chat (Currently Offline)</a><br />
		We currently use Fleetcomm Discord as our chat solution. <a href="https://discordapp.com/invite/0hKG2qb9ODixa7Iz" class="btn btn-dark btn-sm">Join Us There</a><br />
                <br />
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
              </p></article>
            <div class="clearfix"></div>
          </section>
        </div>
        <?php include '../assets/includes/footer.php'; ?>
    </body>
    </html>
