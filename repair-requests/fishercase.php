<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Declare Title, Content, Author
$pgAuthor = "David Sangrey";
$pgContent = "New KingFisher Case";
$useIP = 1; //1 if Yes, 0 if No.

//If you have any custom scripts, CSS, etc, you MUST declare them here.
//They will be inserted at the bottom of the <head> section.
$customContent = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" integrity="sha384-yakM86Cz9KJ6CeFVbopALOEQGGvyBFdmA4oHMiYuHcd9L59pLkCEFSlr6M9m434E" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js" integrity="sha384-Q9RsZ4GMzjlu4FFkJw4No9Hvvm958HqHmXI9nqo5Np2dA/uOVBvKVxAvlBQrDhk4" crossorigin="anonymous"></script>';

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (!securePage($_SERVER['PHP_SELF'])) {
  die();
}

//DB stuff
$db = include 'db.php';
$mysqli = new mysqli($db['server'], $db['user'], $db['pass'], $db['db'], $db['port']);
$platformList = [];
$res = $mysqli->query('SELECT * FROM lookups.platform_lu ORDER BY platform_id');
while ($row = $res->fetch_assoc()) {
  if ($row['platform_name'] == 'ERR') {
    continue;
  }
  $platformList[$row['platform_id']] = $row['platform_name'];
}

//Type of Case. For KFs, only take KF cases (8-11)
$typeList = [];
$res = $mysqli->query('SELECT * FROM lookups.case_color_lu WHERE color_id IN (8, 9 , 10, 11)');
while ($trow = $res->fetch_assoc()) {
  $typeList[$trow['color_id']] = $trow['color_desc'];
}

$data = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['formtype'] == "sendCase") {
  foreach ($_REQUEST as $key => $value) {
    $data[$key] = strip_tags(stripslashes(str_replace(["'", '"'], '', $value)));
  }
  $validationErrors = 0;
  if (strlen($data['cmdr_name']) > 50) {
    usError("CMDR Name too long. Please try again.");
    $validationErrors += 1;
  }
  if (strlen($data['system']) > 100) {
    usError("System name too long. Please try again.");
    $validationErrors += 1;
  }
  if (strlen($data['planet']) > 10) {
    usError("Planet name too long. Please try again.");
    $validationErrors += 1;
  }
  if (strlen($data['curr_coord']) > 20) {
    usError("Invalid Coordinates. Please try again.");
    $validationErrors += 1;
  }
  if (!isset($platformList[$data['platform']])) {
    usError("Invalid Platform. Please try again.");
    $validationErrors += 1;
  }
  if ($validationErrors == 0) {
    $_SESSION['cmdr_name'] = $_POST['cmdr_name'];
    $_SESSION['system'] = $_POST['system'];
    $_SESSION['planet'] = $_POST['planet'];
    $_SESSION['platform'] = $_POST['platform'];
    $_SESSION['curr_coord'] = $_POST['curr_coord'];
    $_SESSION['case_type'] = $_POST['case_type'];
    header("Location: fisherirc.php");
    exit();
  }
}
?>
<h1>Request Repairs</h1>
<br>
<p>Welcome, CMDR. Please enter your details below...</p>
<div class="mx-auto" style="max-width:85%;">
  <div class="alert alert-danger" role="alert">
    Unfortunately, the Seals are experiencing a CMDR shortage on all platforms. Please bear with us as we attempt to respond to as many cases as possible!
  </div>
  <form action="?send" method="post" id="rrForm" onsubmit="Processing()">
    <input hidden type="text" name="formtype" value="sendCase">
    <div class="input-group mb-3">
      <input type="text" name="cmdr_name" pattern="[\x20-\x7A]+" minlength="3" value="<?= $data['cmdr_name'] ?? '' ?>" class="form-control" placeholder="Commander Name" title="Your CMDR name in standard characters." required>
    </div>
    <div class="input-group mb-3">
      <input type="text" name="system" pattern="[\x20-\x7A]+" minlength="3" value="<?= $data['system'] ?? '' ?>" class="form-control" placeholder="System" title="The System name in standard characters." required>
    </div>
    <div class="input-group mb-3">
      <input type="text" name="planet" pattern="[\x20-\x7A]+" minlength="1" value="<?= $data['planet'] ?? '' ?>" class="form-control" placeholder="Planet (ex, '3', 'A', '3 A 2', etc.)" required>
    </div>
    <div class="input-group mb-3">
      <input type="text" name="curr_coord" value="<?= $data['curr_coord'] ?? '' ?>" class="form-control" placeholder="Coordinates (+/-000.000, +/-000.000)" pattern="(\+?|-)\d{1,3}\.\d{3}\,(\+?|-)\d{1,3}\.\d{3}" title="+/-000.000, +/-000.000" required>
      <div class="input-group-append">
        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" id="coord-help-button" data-target="#coordsHelp">
          How do I find this?
        </button>
      </div>
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">Platform</span>
      </div>
      <select name="platform" class="custom-select" id="inputGroupSelect01" placeholder="Platform" required>
        <?php
        foreach ($platformList as $platformId => $platformName) {
          echo '<option value="' . $platformId . '">' . $platformName . '</option>';
        }
        ?>
      </select>
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">What's Wrong?</span>
      </div>
      <select name="case_type" class="custom-select" id="inputGroupSelect01" placeholder="Test" required>
        <?php
        foreach ($typeList as $typeId => $typeName) {
          echo '<option value="' . $typeId . '">' . $typeName . '</option>';
        }
        ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form> <br> <br>
  <p>On Odyssey or LIVE Horizons? You might be able to self-rescue. Click <a href="https://hullseals.space/knowledge/books/guides-and-terms/page/recovery-to-orbit" target="_blank">here</a> for instructions.</p>
  <div class="modal fade" id="coordsHelp" tabindex="-1" style="color:#323232">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="coordsHelpLabel">How do I find my coordinates?</h5>
          <button type="button" class="btn-close" data-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p style="text-align: center;">Coordinates are found in the bottom right of your SRV's HUD.</p>
          <img alt="SRV HUD" src="../images/SRV_HUD.png" class="centerMyImages">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="processing" tabindex="-1" style="color:#323232">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="processing">Processing your Case</h5>
          <button type="button" class="btn-close" data-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p style="text-align: center;">Please stand by while you are redirected...</p>
          <img alt="SRV HUD" src="../images/EDLoader1.svg" class="centerMyImages">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script type='text/javascript'>
  function Processing() {
    $(document).ready(function() {
      $('#processing').modal('show');
    });
  }
</script>
<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
?>