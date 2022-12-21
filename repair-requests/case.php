<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Declare Title, Content, Author
$pgAuthor = "David Sangrey";
$pgContent = "New Repair Case";
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

$data = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['formtype'] == "sendCase") {
  foreach ($_REQUEST as $key => $value) {
    $data[$key] = strip_tags(stripslashes(str_replace(["'", '"'], '', $value)));
  }
  $validationErrors = 0;
  if (!isset($data["platform"])) {
    sessionValMessages("Error! No platform set! Please try again.");
    $validationErrors += 1;
  }
  if ($data['hull'] > 100 || $data['hull'] < 0) {
    sessionValMessages("Error! Invalid hull set! Please try again.");
    $validationErrors += 1;
  }
  if (strlen($data['cmdr_name']) > 50) {
    sessionValMessages("CMDR Name too long. Please try again.");
    $validationErrors += 1;
  }
  if (strlen($data['system']) > 100) {
    sessionValMessages("System name too long. Please try again.");
    $validationErrors += 1;
  }
  if (!isset($data['o2_timer'])) {
    sessionValMessages("Error! No O2 set! Please try again.");
    $validationErrors += 1;
  }
  if (!isset($data['canopy_breached'])) {
    $data['can_synth'] = 0;
  }
  if (!isset($data['can_synth'])) {
    $data['can_synth'] = 0;
  }
  $data['hull'] = (int) $data['hull'];
  $data['canopy_breached'] = isset($data['canopy_breached']);
  if ($data['o2_timer'] != '' && !preg_match('~[0-9]{1,2}:[0-9]{1,2}~i', $data['o2_timer'])) {
    sessionValMessages("Error! invalid O2 Timer Set! status set! Please try again.");
    $validationErrors += 1;
  }
  if ($validationErrors == 0) {
    $_SESSION['cmdr_name'] = $_POST['cmdr_name'];
    $_SESSION['canopy_breached'] = $_POST['canopy_breached'];
    $_SESSION['o2_timer'] = $_POST['o2_timer'];
    $_SESSION['system'] = $_POST['system'];
    $_SESSION['platform'] = $_POST['platform'];
    $_SESSION['hull'] = $_POST['hull'];
    $_SESSION['can_synth'] = $_POST['can_synth'];

    //$stmt = $mysqli->prepare('CALL spCreateHSCaseCleaner(?,?,?,?,?,?,?,?)');
    //$stmt->bind_param('sissiiis', $data['cmdr_name'], $data['canopy_breached'], $data['o2_timer'], $data['system'], $data['platform'], $data['hull'], $data['can_synth'], $lgd_ip);
    //$stmt->execute();
    //foreach ($stmt->error_list as $error) {
    //    $validationErrors[] = 'DB: ' . $error['error'];
    //}
    //$stmt->close();
    header("Location: irc.php");
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
      <input type="text" name="cmdr_name" pattern="[\x20-\x7A]+" minlength="3" value="<?= $data['cmdr_name'] ?? '' ?>" class="form-control" placeholder="Commander Name" title="Your CMDR name in standard characters" required>
    </div>
    <div class="input-group mb-3">
      <input type="text" name="system" pattern="[\x20-\x7A]+" minlength="3" value="<?= $data['system'] ?? '' ?>" class="form-control" placeholder="System" title="The System name in standard characters" required>
    </div>
    <div class="input-group mb-3">
      <input type="number" min="0" max="100" pattern="[0-9]" name="hull" value="<?= $data['hull'] ?? '' ?>" class="form-control" placeholder="Hull %" required>
    </div>
    <div class="input-group mb-3">
      <label id="canopy_breached" class="input-group-text text-primary"><input type="checkbox" id="canopy_breached2" value="1" name="canopy_breached" data-toggle="toggle" data-on="Canopy Breached" data-off="Canopy Not Breached" data-onstyle="danger" data-offstyle="success"> </label>
    </div>
    <div id="ifBreached" class="input-group mb-3">
      <label class="input-group-text text-primary"><input type="checkbox" name="can_synth" value="1" data-toggle="toggle" data-on="O<sub>2</sub> Synths Not Available" data-off="O<sub>2</sub> Synths Available" data-onstyle="danger" data-offstyle="success"></label>
      <div class="input-group-append">
        <button type="button" class="btn btn-secondary" data-toggle="modal" id="coord-help-button" data-target="#coordsHelp">
          What's This?
        </button>
      </div>
    </div>
    <div id="ifBreached2" class="input-group mb-3">
      <input type="text" id="o2_timer" name="o2_timer" value="<?= $data['o2_timer'] ?? '' ?>" class="form-control" pattern="[0-9]{1,2}:[0-9]{1,2}" placeholder="O2 Timer (nn:nn)" title="nn:nn, ex 12:34">
    </div>
    <div id="ifBreached3">
      <img src="/images/logout.png" width="100%" />
      <br /> <br />
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">Platform</span>
      </div>
      <select name="platform" class="custom-select" id="inputGroupSelect01" placeholder="Platform" required>
        <?php
        foreach ($platformList as $platformId => $platformName) {
          echo '<option value="' . $platformId . '"' . '>' . $platformName . '</option>';
        }
        ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  <div class="modal fade" id="coordsHelp" tabindex="-1" style="color:#323232">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="coordsHelpLabel">What is this?</h5>
          <button type="button" class="btn-close" data-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p style="text-align: center;">Life Support Synthesis is a way to temporarily refill your life support timer. <br /> They cost 2 Iron and 1 Nickel per refill, and can be found in your right-hand panel.
            <hr />
          </p>

          <p style="text-align: center;">Don't know if you have any? That's Okay! Just choose "O<sub>2</sub> Synths Not Available".</p>
          <p style="text-align: center;"><em>Do <strong>NOT</strong> log in to check if you don't know!</em></p>
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
<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
?>
<script>
  var ifBreachedBlock = $('#ifBreached');
  var ifBreachedBlock2 = $('#ifBreached2');
  var ifBreachedBlock3 = $('#ifBreached3');
  var o2_timer = document.getElementById('o2_timer');

  ifBreachedBlock.hide();
  ifBreachedBlock2.hide();
  ifBreachedBlock3.hide();

  let searchParams = new URLSearchParams(window.location.search)
  searchParams.has('code')
  let code = searchParams.get('code')
  if (code == "black") {
    $("#canopy_breached2").attr("checked", code.indexOf("black") !== -1);
    ifBreachedBlock.show();
    ifBreachedBlock2.show();
    ifBreachedBlock3.show();
    o2_timer.setAttribute('required', '');
    $("[data-toggle='toggle']").bootstrapToggle('destroy')
    $("[data-toggle='toggle']").bootstrapToggle();
  }



  $(function() {
    $('#canopy_breached2').change(function() {
      if ($(this).prop('checked')) {
        ifBreachedBlock.show();
        ifBreachedBlock2.show();
        ifBreachedBlock3.show();
        o2_timer.setAttribute('required', '');
        $("[data-toggle='toggle']").bootstrapToggle('destroy')
        $("[data-toggle='toggle']").bootstrapToggle();
      } else {
        ifBreachedBlock.hide();
        ifBreachedBlock2.hide();
        ifBreachedBlock3.hide();
        o2_timer.removeAttribute('required');
        $("[data-toggle='toggle']").bootstrapToggle('destroy')
        $("[data-toggle='toggle']").bootstrapToggle();
      }
    })
  })
</script>
<script type='text/javascript'>
  function Processing() {
    $(document).ready(function() {
      $('#processing').modal('show');
    });
  }
</script>