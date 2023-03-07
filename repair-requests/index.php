<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Declare Title, Content, Author
$pgAuthor = "David Sangrey";
$pgContent = "Request a Repair";
$useIP = 1; //1 if Yes, 0 if No.

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (!securePage($_SERVER['PHP_SELF'])) {
  die();
}

$lore = [];
if (isset($_POST['re_join'])) {
  foreach ($_REQUEST as $key => $value) {
    $lore[$key] = strip_tags(stripslashes(str_replace(["'", '"'], '', $value)));
  }
  $rejoinNick = $lore['re_join'];
  header("Location: https://client.hullseals.space:8443/repair.html?nick=" . $rejoinNick);
  die();
}
if (isset($_POST['chatting'])) {
  foreach ($_REQUEST as $key => $value) {
    $lore[$key] = strip_tags(stripslashes(str_replace(["'", '"'], '', $value)));
  }
  $chatNick = $lore['chatting'];
  header("Location: https://client.hullseals.space:8443/?nick=" . $chatNick);
  die();
}
?>
<h1>Request Repairs</h1>
<h2>Please choose an option below...</h2>
<p><strong>Do you see a countdown timer?</strong><br>
  <em style="color:red;">If so, log out to the menu immediately</em><br>
  <hr>
<div class="row">
  <div class="col-7">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="list-case" role="tabpanel">
        <h2>Hull Damage? We can help!</h2>
        <p>Please fill out the form below and stay connected.</p>
        <a class="btn btn-lg btn-success" href="case.php">Yes, I Need Repairs</a>
        <hr>
        <h2>Broken Canopy?</h2>
        <p style="color:red">LOG OUT TO THE MAIN MENU IMMEDIATELY.</p>
        <p>Do not log in until directed to by our Dispatchers.</p>
        <a class="btn btn-lg btn-danger" href="case.php?code=black">My Canopy is Broken</a>
      </div>
      <div class="tab-pane fade" id="list-kf" role="tabpanel">
        <p>Stuck in your SRV? We can help!</p>
        <p>Call our expert KingFishers today!</p>
        <a class="btn btn-lg btn-success" href="fishercase.php">Yes, I Need SRV Help</a> <br /><br />
        <p>Note: CMDRs on Odyssey or LIVE Horizons might be able to self-rescue. Click <a href="https://hullseals.space/knowledge/books/guides-and-terms/page/recovery-to-orbit" target="_blank">here</a> for instructions.</p>
      </div>
      <div class="tab-pane fade" id="list-module" role="tabpanel">
        <p>Unfortunately, we cannot repair module damage, other than cracked or broken canopies.</p>
        <p>Only stations, Fleet Carriers, or AFMU modules can repair module damage.</p>
        <p>A <a href="https://elite-dangerous.fandom.com/wiki/Reboot_and_Repair" target="_blank">reboot and repair</a> cycle may help get damaged modules to working order long enough to get to an advanced repair facility.</p>
      </div>
      <div class="tab-pane fade" id="list-disco" role="tabpanel">
        <p>Lost connection to chat? That's okay! Just click here to get back in the action.</p>
        <p>Simply enter your name below and get reconnected!</p>
        <form action="?re_join" method="post">
          <div class="input-group mb-3">
            <input type="text" name="re_join" value="<?= $lore['re_join'] ?? '' ?>" pattern="[a-zA-Z0-9]+" class="form-control" placeholder="CMDR Name" required>
          </div>
          <button class="btn btn-primary" type="submit">Rejoin the Case</button>
        </form>
      </div>
      <div class="tab-pane fade" id="list-chat" role="tabpanel">
        <p>Want to swing by and talk to our Seals? You're always welcome.</p>
        <form action="?chatting" method="post">
          <div class="input-group mb-3">
            <input type="text" name="chatting" value="<?= $lore['chatting'] ?? '' ?>" pattern="[a-zA-Z0-9]+" class="form-control" placeholder="CMDR Name" required>
          </div>
          <button class="btn btn-primary" type="submit">Chat with our Seals</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-5">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-dark list-group-item-action active" id="list-case-list" data-toggle="list" href="#list-case" role="tab">Need Repairs or Broken Canopy?</a>
      <a class="list-group-item list-group-item-dark list-group-item-action" id="list-kf-list" data-toggle="list" href="#list-kf" role="tab">Stuck SRV?</a>
      <a class="list-group-item list-group-item-dark list-group-item-action" id="list-module-list" data-toggle="list" href="#list-module" role="tab">Module Repairs?</a>
      <a class="list-group-item list-group-item-dark list-group-item-action" id="list-disco-list" data-toggle="list" href="#list-disco" role="tab">Disconnected from a Case?</a>
      <a class="list-group-item list-group-item-dark list-group-item-action" id="list-chat-list" data-toggle="list" href="#list-chat" role="tab">Just Chatting?</a>
    </div>
  </div>
</div>
<p>
  <hr>
  <strong>By connecting to our services, you agree to abide by our <a href="https://hullseals.space/knowledge/books/important-information">TOS and Privacy Policy</a></strong>
</p>
<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
?>