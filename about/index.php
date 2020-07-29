<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
if (!securePage($_SERVER['PHP_SELF'])){die();}

$activePage = 'about';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="About the Hull Seals" name="description">
    <title>About | The Hull Seals</title>
    <?php include '../assets/includes/headerCenter.php'; ?>
</head>
<body>
    <div id="home">
      <?php include '../assets/includes/menuCode.php';?>
        <section class="introduction container">
	    <article id="intro3">
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
             We'll see you out there, CMDR.</p></article>
            <div class="clearfix"></div>
        </section>
      </div>
      <?php include '../assets/includes/footer.php'; ?>
  </body>
  </html>
