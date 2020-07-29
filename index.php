<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//UserSpice Required
require_once 'users/init.php';  //make sure this path is correct!
if (!securePage($_SERVER['PHP_SELF'])){die();}

$activePage = 'home';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="Welcome to the Hull Seals, Elite Dangerous's Premier Hull Repair Specialists!" name="description">
    <title>Home | The Hull Seals</title>
    <?php include 'assets/includes/header.php'; ?>
</head>
<body>
    <div id="home">
      <?php include 'assets/includes/menuCode.php';?>
        <section class="introduction">
	    <article id="intro3">
                <h1>Welcome to the <em>Hull Seals</em><span class="hidden-xs">, your premier hull repair specialists</span>.</h1>
                <br /><br />
                <a href="repair-requests" class="btn btn-success btn-lg active" >Request a Repair</a>
            </article>
            <div class="clearfix"></div>
        </section>
    </div>
    <?php include 'assets/includes/footer.php'; ?>
</body>
</html>
