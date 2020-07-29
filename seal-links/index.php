<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
if (!securePage($_SERVER['PHP_SELF'])){die();}?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="Your Resources for the Seals" name="description">
    <title>Seal Links | The Hull Seals</title>
    <?php include '../assets/includes/headerCenter.php'; ?>
    <script>
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
</head>
<body>
    <div id="home">
      <?php include '../assets/includes/menuCode.php';?>
        <section class="introduction container">
	    <article id="intro3">
              <div style="text-align: center;">
                <h1>
                  Seal Links
                </h1>
                <div style="text-align: left">
                  <h2>Hello, <?php echo echousername($user->data()->id); ?>!</h2>
                <p>This section contains several Seal internal links. <br />
                  Please do not share private links with non-seals.</p>
              </div>
                <hr><br><h3>User and Profile Links</h3>
                <p>
                  <div class="btn-group btn-group-lg d-flex mx-auto" role="group" style="max-width:85%;">
                    <a href="https://hullseals.space/users/account.php" class="btn btn-info">My Profile</a>
                    <a href="https://hullseals.space/users/manage_sessions.php" class="btn btn-info">Session Management</a>
                  </div>
                </p>
                <hr><br><h3>Public Links</h3>
		            <p>
                  <div class="btn-group btn-group-lg d-flex mx-auto" role="group" style="max-width:85%;">
                    <a href="https://hullseals.space/bugreport" class="btn btn-info">Bug Reports</a>
                    <a href="https://hullse.al/issuetrack" class="btn btn-info">Issue Tracker</a>
                    <a href="https://hullseals.space/knowledge/" class="btn btn-info">Knowledge Base</a>
                  </div>
                  <br>
                  <br>
                  <div class="btn-group btn-group-lg d-flex mx-auto" role="group" style="max-width:85%;">
                    <a href="https://hullseals.space/SuperSecretDiscordLink" class="btn btn-info">Social Discord</a>
                    <a href="https://discordapp.com/invite/0hKG2qb9ODixa7Iz" class="btn btn-info">Fleetcomm Discord</a>
                  </div>
                  <br>
                  <br>
                  <div class="btn-group btn-group-lg d-flex mx-auto" role="group" style="max-width:85%;">
                    <a href="https://hullseals.space/merch/" class="btn btn-info">Merch Store</a>
                    <a href="https://hullseals.space/patch-store/" class="btn btn-info">Patches</a>
                    <a href="https://hullseals.space/donate/" class="btn btn-info">Donations</a>
                  </div>
                </p>
                <hr><br><h3>Seal Links</h3>
                <p>
                  <div class="btn-group btn-group-lg d-flex mx-auto" role="group" style="max-width:85%;">
                    <a href="https://hullseals.space/paperwork/" class="btn btn-info">Paperwork</a>
                    <a href="https://hullseals.space/cmdr-management/" class="btn btn-info">CMDR Management</a>
                    <a href="https://hullseals.space/vessel-registry/" class="btn btn-info">Vessel Registry</a>
                  </div>
                  <br>
                  <br>
                  <div class="btn-group btn-group-lg d-flex mx-auto" role="group" style="max-width:85%;">
                    <a href="#" class="btn btn-info disabled" data-toggle="tooltip" title="Coming Soon!">Training Portal</a>
                    <a href="https://hullse.al/FantasticShortlinksAndWhereTheyLead" class="btn btn-info">Shortlink List</a>
                    <a href="#" class="btn btn-info disabled" data-toggle="tooltip" title="Coming Soon!">Textbin</a>
                  </div>
                </p>
                <?php if(hasPerm([5,6],$user->data()->id)){?>
                <hr><br><h3>Dispatch Links</h3>
                <p>
                  <div class="btn-group btn-group-lg d-flex mx-auto" role="group" style="max-width:85%;">
                    <a href="#" class="btn btn-info disabled" data-toggle="tooltip" title="Coming Soon!">Dispatch Board</a>
                    <a href="#" class="btn btn-info disabled" data-toggle="tooltip" title="Coming Soon!">Case Review</a>
                  </div>
                </p>
              <?php }?>
              <?php if(hasPerm([4],$user->data()->id)){?>
                <hr><br><h3>Trainer Links</h3>
                <p>
                  <div class="btn-group btn-group-lg d-flex mx-auto" role="group" style="max-width:85%;">
                    <a href="https://hullseals.space/trainings/dashboard/" class="btn btn-info">Training Dashboard</a>
                    <a href="https://hullseals.space/trainings/dashboard/manage.php" class="btn btn-info">Manage Pups</a>
                    <a href="https://hullseals.space/trainer-lookup/" class="btn btn-info" data-toggle="tooltip" title="Depreciated. Please use Pup Management.">Old Trainer Lookup</a>
                  </div>
                </p>
              <?php }?>
                <?php if(hasPerm([8,9],$user->data()->id)){?>
                <hr><br><h3>CyberSeal Links</h3>
                <p>
                  <div class="btn-group btn-group-lg d-flex mx-auto" role="group" style="max-width:85%;">
                    <a href="https://gitlab.com/hull-seals-cybersealsh" class="btn btn-info">GitLab</a>
                    <a href="hullseals.space/users/admin.php" class="btn btn-info">User Management</a>
                    <a href="#" class="btn btn-info disabled">Beta Site</a>
                  </div>
                  <br>
                  <br>
                  <div class="btn-group btn-group-lg d-flex mx-auto" role="group" style="max-width:85%;">
                    <a href="#" class="btn btn-info disabled">Password Manager</a>
                    <a href="#" class="btn btn-info disabled">Fallback Site</a>
                  </div>
                </p>
            <?php }?>
              </div>
            </article>
            <div class="clearfix"></div>
        </section>
      </div>
      <?php include '../assets/includes/footer.php'; ?>
  </body>
  </html>
