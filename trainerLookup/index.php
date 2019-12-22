<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../users/init.php';  //make sure this path is correct!
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>
<!DOCTYPE html>
<html>
<body>

<h2>Look Up Seals</h2>
<form action="results.php" method=POST>
  Seal name:<br>
  <input type="text" name="seal_name" value="">
  <input type="submit" value="Submit">
</form>
<h3>This system is for use of Trainers Only.</h3>
<h6>Or Rix, if he decides to abuse it.</h6>
</body>
</html>
