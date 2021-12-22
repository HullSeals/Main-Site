<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Declare Title, Content, Author
$pgAuthor = "David Sangrey";
$pgContent = "Request a Repair";
$useIP = 1; //1 if Yes, 0 if No.

//If you have any custom scripts, CSS, etc, you MUST declare them here.
//They will be inserted at the bottom of the <head> section.
$customContent = '';

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}

$lore = [];
if (isset($_POST['re_join'])) {
    foreach ($_REQUEST as $key => $value) {
        $lore[$key] = strip_tags(stripslashes(str_replace(["'", '"'], '', $value)));
    }
		$rejoinNick = $lore['re_join'];
  header("Location: https://client.hullseals.space:8443/repair.html?nick=". $rejoinNick);
}
?>
<h1>Request Repairs</h1>
				<h2>Please choose an option below...</h2>
				<p><strong>Do you see a countdown timer?</strong><br>
				<em style="color:red;">If so, log out to the menu immediately</em><br>
				<br>
				Do you need repairs or is your canopy broken?<br>
				<a class="btn btn-success" href="case.php">Yes, I Need Repairs</a><br>
				<br>
				Is your SRV Stuck?<br>
				<a class="btn btn-success" href="fishercase.php">Yes, I Need SRV Help</a><br>
				<br>
				Do you need Module Repairs?<br>
				<button class="btn btn-warning" data-target="#coordsHelp" data-toggle="modal" id="coord-help-button" type="button">I need module repairs!</button><br>
				<br>
				Disconnected from an Ongoing Case?<br>
				<button class="btn btn-secondary" data-target="#rejoinRepair" data-toggle="modal" id="coord-help-button" type="button">Rejoin the Chat</button><br>
				<br>
				Just want to talk or join up?<br>
				<a class="btn btn-secondary" href="https://client.hullseals.space">Just Chatting!</a></p>
				<hr>
				<p><strong>By connecting to our services, you agree to abide by our <a href="https://hullseals.space/knowledge/books/important-information">TOS and Privacy Policy</a></strong></p>
				<div aria-hidden="true" class="modal fade" id="coordsHelp" style="color:#323232" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="coordsHelpLabel">How do Repair Modules?</h5><button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<p>Unfortunately, we cannot repair module damage, other than cracked or broken canopies.<br>
								Only stations, Fleet Carriers, or AFMU modules can repair module damage.<br>
								A reboot and repair cycle may help get damaged modules to working order long enough to get to an advanced repair facility.</p>
							</div>
							<div class="modal-footer">
								<button class="btn btn-secondary" data-dismiss="modal" type="button">I Understand</button>
							</div>
						</div>
					</div>
				</div>
				<div aria-hidden="true" class="modal fade" id="rejoinRepair" style="color:#323232" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="rejoinRepairLabel">Rejoin an Ongoing Repair</h5><button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<p>Got disconnected? Simply enter your name below and get reconnected!</p>
								<form action="?re_join" method="post">
									<div class="input-group mb-3">
                        <input type="text" name="re_join" value="<?= $lore['re_join'] ?? '' ?>" pattern="[a-zA-Z0-9]+" class="form-control" placeholder="CMDR Name" aria-label="CMDR Name" required>
                    </div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-primary" type="submit">Rejoin the Case</button><button class="btn btn-secondary" data-dismiss="modal" type="button">Exit</button>
							</div>
						</div>
					</div>
				</div>

<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
