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
    <meta content="Welcome to the Hull Seals, Elite Dangerous's Premier Hull Repair Specialists!" name="description">
    <title>Home | The Hull Seals</title>
    <?php include '../assets/includes/header.php'; ?>
</head>
<body>
    <div id="home">
      <?php include '../assets/includes/menuCode.php';?>
        <section class="introduction">
	    <article id="intro3">
                <h1>Request Repairs</h1>
               	<h2>Repairs are handled through Fleetcomm Discord. Links below.</h2>
		<p>
                  <strong>
                    Do you see a countdown timer?
                  </strong>
                  <br />
                  <em>
                    If so, log out to the menu immediately
                  </em>
                  <br />
                  <br />
                  Do you need repairs or Code Black canopy breach services?
                  <br />
                  <a href="https://discordapp.com/invite/0hKG2qb9ODixa7Iz" class="btn btn-success btn-lg">Yes, I Need Repairs</a>
                  <br />
                  <br />
                  Just want to talk or join up?
                  <br />
                  <a href="https://discordapp.com/invite/0hKG2qb9ODixa7Iz" class="btn btn-secondary btn-lg">Just Chatting!</a>
                </p>
              </article>
                    <div class="clearfix"></div>
                </section>
              </div>
              <?php include '../assets/includes/footer.php'; ?>
          </body>
          </html>
