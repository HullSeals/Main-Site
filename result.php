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
<h1>Journal Reader Results</h1><br>
<h2>Copy and paste the following into the chat as requested by dispatch</h2><br>
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
echo "<div align=\x22center\x22>";
echo "<h3>Ship info</h3>";
echo "<p>Current Location: ".$info['system']."</p>";
echo "<p>Current hull percentage: ".$info['hull']."</p>";
// adding color to these lines and logic so it doesn't show o2 or ls for no breach - HW
echo "<p class=\x22critical1\x22>Is canopy breached: ".$info['breach']."</p>";
if ( $info['breach'] == 'true' ) {
	echo "<p class=\x22critical2\x22>Oxygen in minutes: ".$info['oxygen']."</p>";
	echo "<p>Life support synth count: ".$info['lifesupport']."</p>";
}

/** TODO - add lines for SRV Data - HW
 *  echo "<h3>SRV Coordinates</h3>";
 *  
 */
 
echo "</div>";
// Commenting out the debug dump - HW
// var_dump($_SESSION['debug']);

echo "</body>";