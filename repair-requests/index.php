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
    <title>Request a Repair | The Hull Seals</title>
    <?php include '../assets/includes/headerCenter.php'; ?>
</head>
<body>
    <div id="home">
      <?php include '../assets/includes/menuCode.php';?>
        <section class="introduction">
	    <article id="intro3" style="margin: 2rem 20rem;">
                <h1>Request Repairs</h1>
               	<h2>Please choose an option below...</h2>
		<br>
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
                  Do you need Repairs or Code Black canopy breach services?
                  <br />
                  <a href="https://discordapp.com/invite/0hKG2qb9ODixa7Iz" class="btn btn-success btn-lg">Yes, I Need Repairs</a>
		  <br /><br>
		  Do you need Kingfisher SRV Assistance?
		  <br />
		  <a href="https://discordapp.com/invite/0hKG2qb9ODixa7Iz" class="btn btn-success btn-lg">Yes, I Need SRV Help</a>
		  <br /><br>
	 	  Do you need Module Repairs?<br>
		  <button type="button" class="btn btn-success btn-lg" data-toggle="modal" id="coord-help-button" data-target="#coordsHelp">
I need module repairs!
</button>
		  <br><br>
                  Just want to talk or join up?
                  <br />
                  <a href="https://discordapp.com/invite/0hKG2qb9ODixa7Iz" class="btn btn-secondary btn-lg">Just Chatting!</a>
		</p>
		<hr>
		<p><strong>By connecting to our services, you agree to abide by our <a href="https://hullseals.space/knowledge/books/important-information">TOS and Privacy Policy</a></strong></p>
<div class="modal fade" id="coordsHelp" tabindex="-1" aria-hidden="true" style="color:#323232">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="coordsHelpLabel">How do Repair Modules?</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<p style="text-align: center;">Unfortunately, we cannot repair module damage.<br> Only stations, Fleet Carriers, or AFMU modules can repair module damage.<br> A reboot and repair cycle may help get damaged modules to working order long enough to get to an advanced repair facility.</p>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">I Understand</button>
	</div>
	</div>
	</div>
	</div>
		      </article>
			    <div class="clearfix"></div>
			</section>
		      </div>
		      <?php include '../assets/includes/footer.php'; ?>
          </body>
          </html>
