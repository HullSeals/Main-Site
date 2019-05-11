<!DOCTYPE html>
<html  lang="en">
<head>
	<link href="favicon.ico" rel="icon" type="image/x-icon">
	<link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
	<meta charset="UTF-8">
	<meta content="Wolfii Namakura" name="author">
	<meta content="hull seals, elite dangerous, distant worlds, seal team fix, mechanics, dw2" name="keywords">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0" name="viewport">
	<meta content="Welcome to the Hull Seals, Elite Dangerous's Premier Hull Repair Specialists!" name="description">
	<title>Journal Reader Results | The Hull Seals</title>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link href="styles.css" rel="stylesheet" type="text/css">
	</script>
	<style>
		.critical1
		{
			color: yellow;
		}
		.critical2
		{
			color: red;
		}
	</style>
</head>
<body>
	<div id="home">
        <header>
            <nav class="navbar container navbar-expand-lg navbar-expand-md navbar-dark" role="navigation">
                <a class="navbar-brand" href="../index.html">
                    <img src="../images/emblem_scaled.png" height="30" class="d-inline-block align-top" alt="Logo" /> Hull Seals</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="../index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../knowledge">Knowledge Base</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Chat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://forums.frontier.co.uk/showthread.php/452349-DW2-Fleet-Mechanics">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://inara.cz/squadron/5050/">Inara Squadron</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
		<section class="introduction">
            <article>
				<h1>Journal Reader Results</h1><br>
				<h2>Copy and paste the following into the chat as requested by dispatch</h2><br>
				<div align="center">
					<span id="journalresults">
					<h3>Ship info</h3>
					<?php
						/**
						* Created by PhpStorm.
						* User: Lars
						* Date: 30/03/2019
						* Time: 14:48
						*/
						session_start();
						$info = $_SESSION['info'];
						// added echo formatting - HW
						echo "<p>Current Location: ".$info['system']."</p>";
						echo "<p>Current hull percentage: ".$info['hull']."</p>";
						// adding color to these lines and logic so it doesn't
						// show o2 or ls for no breach - HW
						echo "<p class=\x22critical1\x22>Is canopy breached: ".$info['breach']."</p>";
						if ( $info['breach'] == 'true' ) {
							echo "<p class=\x22critical2\x22>Oxygen in minutes: ".$info['oxygen']."</p>";
							echo "<p>Life support synth count: ".$info['lifesupport']."</p>";
						}

						/** TODO - add lines for SRV Data - HW
						*  echo "<h3>SRV Coordinates</h3>";
						*  
						*/
						
						// Commenting out the debug dump - HW
						// var_dump($_SESSION['debug']);
					?>
					</span>
					<button id="copyResults" class="btn btn-success btn-lg" onclick="copyJournal()">Click to Copy</button>
					<script>
						function copyJournal() {
							var journalText = document.createElement("textarea")
							journalText.value = document.getElementById("journalresults").innerHTML;
							document.body.appendChild(journalText);
							journalText.value = journalText.value.replace(/\t/g,"");
							journalText.value = journalText.value.replace(/<h3>/g,"");
							journalText.value = journalText.value.replace(/<\/h3>/g,"\n");
							journalText.value = journalText.value.replace(/<p>/g,"");
							journalText.value = journalText.value.replace(/<\/p>/g,"\n");
							journalText.value = journalText.value.replace(/<p class="critical\d">/g,"");
							journalText.focus();
							journalText.select();
							document.execCommand('copy');
							document.body.removeChild(journalText);
						}
					</script>
				</div>
			</article>
			<div class="clearfix"></div>
		</section>
	</div>
	<footer class="page-footer font-small">
        <div class="container">
            <div class="row">
                <div class="col-md-9 mt-md-0 mt-3">
                    <h5 class="text-uppercase">Hull Seals</h5>
                    <p>
                        <em>The Hull Seals</em> were established in January of 3305, and have begun plans to roll out galaxy-wide!</p>
                    <a href="https://fuelrats.com/i-need-fuel" class="btn btn-sm btn-secondary">Need Fuel? Call the Rats!</a>
                </div>
                <hr class="clearfix w-100 d-md-none pb-3" />
                <div class="col-md-3 mb-md-0 mb-3">
                    <h5 class="text-uppercase">Links</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="https://twitter.com/HullSeals">
                                <img alt="Twitter" height="20" src="../images/twitter_loss.png" width="20" /> Twitter</a>
                        </li>
                        <li>
                            <a href="../donate">Donate</a>
                        </li>
                        <li>
                            <a href="https://hullseals.space/knowledge/books/important-information/page/privacy-policy">Privacy &amp; Cookies
							Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">Site content copyright © 2019, The Hull Seals. All Rights Reserved. Elite Dangerous and all related marks are trademarks of Frontier Developments Inc.</div>
    </footer>
</body>

</html>