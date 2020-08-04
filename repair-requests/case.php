<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
if (!securePage($_SERVER['PHP_SELF'])){die();}

//ipInfo
require '../assets/includes/ipinfo.php';

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

$validationErrors = [];
$data = [];
if (isset($_GET['send'])) {
    foreach ($_REQUEST as $key => $value) {
        $data[$key] = strip_tags(stripslashes(str_replace(["'", '"'], '', $value)));
    }
    if (strlen($data['cmdr_name']) > 50) {
        $validationErrors[] = 'commander name too long';
    }
    if (strlen($data['system']) > 100) {
        $validationErrors[] = 'system too long';
    }

    $data['hull'] = (int) $data['hull'];
    if ($data['hull'] > 100 || $data['hull'] < 0) {
        $validationErrors[] = 'invalid hull';
    }
    $data['canopy_breached'] = isset($data['canopy_breached']);
    $data['can_synth'] = isset($data['can_synth']);
    if ($data['o2_timer'] != '' && !preg_match('~[0-9]{1,2}:[0-9]{1,2}~i', $data['o2_timer'])) {
        $validationErrors[] = 'invalid O2 timer';
    }

    if (!isset($platformList[$data['platform']])) {
        $validationErrors[] = 'invalid platform';
    }
    if (!count($validationErrors)) {
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="New Repair Case" name="description">
    <title>New Case | The Hull Seals</title>
    <?php include '../assets/includes/headerCenter.php'; ?>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js" integrity="sha384-Q9RsZ4GMzjlu4FFkJw4No9Hvvm958HqHmXI9nqo5Np2dA/uOVBvKVxAvlBQrDhk4" crossorigin="anonymous"></script>
</head>

</head>
<body>
    <div id="home">
      <?php include '../assets/includes/menuCode.php';?>
        <section class="introduction container">
	    <article id="intro3">
        <h1>Request Repairs</h1>
        <br>
        <p>Welcome, CMDR. Please enter your details below...</p>
        <?php
        if (count($validationErrors)) {
            foreach ($validationErrors as $error) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            echo '<br>';
        }
        ?>
        <div class="mx-auto" style="max-width:85%;">
        <form action="?send" method="post" id="rrForm">
            <div class="input-group mb-3">
                <input type="text" name="cmdr_name" value="<?= $data['cmdr_name'] ?? '' ?>" class="form-control" placeholder="Commander Name" aria-label="Commander Name" required>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="system" value="<?= $data['system'] ?? '' ?>" class="form-control" placeholder="System" aria-label="System" required>
            </div>
            <div class="input-group mb-3">
                <input type="number" min="0" max="100" name="hull" value="<?= $data['hull'] ?? '' ?>" class="form-control" placeholder="Hull %" aria-label="Hull %" required>
            </div>
            <div class="input-group mb-3">
            		<label id="canopy_breached" class="input-group-text text-primary"><input type="checkbox" id="canopy_breached2" value="1" name="canopy_breached" data-toggle="toggle" data-on="Canopy Breached" data-off="Canopy Not Breached" data-onstyle="danger" data-offstyle="success">  </label>
              </div>
            <div id="ifBreached" class="input-group mb-3">
              <label class="input-group-text text-primary"><input type="checkbox" name="can_synth" value="1" data-toggle="toggle" data-on="Synths Not Available" data-off="Synths Available" data-onstyle="danger" data-offstyle="success"></label>
            </div>
            <div id="ifBreached2" class="input-group mb-3">
              <input type="text" name="o2_timer" value="<?= $data['o2_timer'] ?? '' ?>" class="form-control" pattern="[0-9]{1,2}:[0-9]{1,2}" placeholder="O2 Timer (nn:nn)" aria-label="O2 Timer (nn:nn)">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Platform</span>
                </div>
                <select name="platform" class="custom-select" id="inputGroupSelect01" placeholder="Test" required>
                    <?php
                    foreach ($platformList as $platformId => $platformName) {
                        echo '<option value="' . $platformId . '"' . ($data['platform'] == $platformId ? ' checked' : '') . '>' . $platformName . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </article>
<div class="clearfix"></div>
</section>
</div>
<?php include '../assets/includes/footer.php'; ?>
</body>
</html>
<script>
var ifBreachedBlock = $('#ifBreached');
var ifBreachedBlock2 = $('#ifBreached2');

ifBreachedBlock.hide();
ifBreachedBlock2.hide();


  $(function() {
    $('#canopy_breached2').change(function() {
      if ($(this).prop('checked')) {
        ifBreachedBlock.show();
        ifBreachedBlock2.show();
        $("[data-toggle='toggle']").bootstrapToggle('destroy')
        $("[data-toggle='toggle']").bootstrapToggle();
      } else {
        ifBreachedBlock.hide();
        ifBreachedBlock2.hide();
        $("[data-toggle='toggle']").bootstrapToggle('destroy')
        $("[data-toggle='toggle']").bootstrapToggle();
      }
    })
  })
</script>
