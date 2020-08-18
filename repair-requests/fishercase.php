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

//Type of Case. For KFs, only take KF cases (8-11)
$typeList = [];
$res = $mysqli->query('SELECT * FROM lookups.case_color_lu WHERE color_id IN (8, 9 , 10, 11)');
while ($trow = $res->fetch_assoc()) {
    $typeList[$trow['color_id']] = $trow['color_desc'];
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
    if (strlen($data['planet']) > 100) {
        $validationErrors[] = 'planet too long';
    }
    if (strlen($data['curr_coord']) > 20) {
        $validationErrors[] = 'coordinates too long';
    }
    if (!isset($platformList[$data['platform']])) {
        $validationErrors[] = 'invalid platform';
    }
    if (!count($validationErrors)) {
      $_SESSION['cmdr_name'] = $_POST['cmdr_name'];
      $_SESSION['system'] = $_POST['system'];
      $_SESSION['planet'] = $_POST['planet'];
      $_SESSION['platform'] = $_POST['platform'];
      $_SESSION['curr_coord'] = $_POST['curr_coord'];
      $_SESSION['case_type'] = $_POST['case_type'];
      header("Location: fisherirc.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="New Repair Case" name="description">
    <title>New Case | The Hull Seals</title>
    <?php include '../assets/includes/headerCenter.php'; ?>
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
                <input type="text" name="planet" value="<?= $data['planet'] ?? '' ?>" class="form-control" placeholder="Planet" aria-label="Planet" required>
            </div>
            <div class="input-group mb-3">
              <input type="text" name="curr_coord" value="<?= $data['curr_coord'] ?? '' ?>" class="form-control" placeholder="Coordinates (+/-000.000, +/-000.000)" aria-label="Coordinates" pattern="(\+?|-)\d{1,3}\.\d{3}\,(\+?|-)\d{1,3}\.\d{3}" required>
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
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">What's Wrong?</span>
              </div>
              <select name="case_type" class="custom-select" id="inputGroupSelect01" placeholder="Test" required>
                <?php
                  foreach ($typeList as $typeId => $typeName) {
                    echo '<option value="' . $typeId . '"' . ($trow['case_type'] == $typeId ? ' checked' : '') . '>' . $typeName . '</option>';
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
