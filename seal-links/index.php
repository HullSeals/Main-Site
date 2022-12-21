<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Declare Title, Content, Author
$pgAuthor = "David Sangrey";
$pgContent = "Your Resources for the Seals";
$useIP = 0; //1 if Yes, 0 if No.

//UserSpice Required
require_once '../users/init.php';  //make sure this path is correct!
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (!securePage($_SERVER['PHP_SELF'])) {
  die();
}
?>
<div style="text-align: center;">
  <h1>
    Seal Links
  </h1>
  <div style="text-align: left">
    <h2>Hello, <?php echo echousername($user->data()->id); ?>!</h2>
    <p>This section contains several Seal internal links. <br />
      Please do not share private links with non-seals.</p>
  </div>
  <hr><br>
  <h3>Public Links</h3>
  <p>
  <ul class="list-group list-group-horizontal-sm">
    <a href="https://hullseals.space/knowledge/" class="list-group-item list-group-item-action">Wiki</a>
    <a href="https://hullseals.space/statistics" class="list-group-item list-group-item-action">Stats</a>
    <a href="https://store.hullseals.space" class="list-group-item list-group-item-action">Merch</a>
    <a href="https://hullseals.space/donate/" class="list-group-item list-group-item-action">Donations</a>
    <a href="https://client.hullseals.space" class="list-group-item list-group-item-action">IRC WebClient</a>
  </ul>
  </p>
  <hr><br>
  <h3>Seal Links</h3>
  <p>
  <ul class="list-group list-group-horizontal-sm">
    <a href="https://hullseals.space/cmdr-management/" class="list-group-item list-group-item-action">IRC and CMDR Management</a>
    <a href="https://hullseals.space/vessel-registry/" class="list-group-item list-group-item-action">Vessel Registry</a>
    <a href="https://hullseals.space/paperwork/" class="list-group-item list-group-item-action">Paperwork</a>
    <a href="https://hullseals.space/dispatch-tools/my-cases.php" class="list-group-item list-group-item-action">My Past Cases</a>
    <a href="https://hullseals.space/trainings/scheduling/" class="list-group-item list-group-item-action">Training Requests</a>
    <a href="https://hullse.al/FantasticShortlinksAndWhereTheyLead" class="list-group-item list-group-item-action">Shortlink List</a>
  </ul>
  </p>
  <?php if (hasPerm([5, 6], $user->data()->id)) { ?>
    <hr><br>
    <h3>Dispatch Links</h3>
    <p>
    <ul class="list-group list-group-horizontal-sm">
      <a href="https://hullseals.space/dispatch-tools/cases-list.php" class="list-group-item list-group-item-action">Case Review Portal</a>
      <a href="https://hullseals.space/dispatch-tools/delayed/" class="list-group-item list-group-item-action">Delayed Case Management</a>
    </ul>
    </p>
  <?php } ?>
  <?php if (hasPerm([4], $user->data()->id)) { ?>
    <hr><br>
    <h3>Trainer Links</h3>
    <p>
    <ul class="list-group list-group-horizontal-sm">
      <a href="https://hullseals.space/trainings/scheduling/requests.php" class="list-group-item list-group-item-action">Scheduling System</a>
      <a href="https://hullseals.space/trainings/dashboard/manage.php" class="list-group-item list-group-item-action">Seal Management</a>
      <a href="https://hullseals.space/trainings/training-paperwork/" class="list-group-item list-group-item-action">Drill Paperwork</a>
      <a href="https://hullseals.space/trainings/dashboard/paperwork-list.php" class="list-group-item list-group-item-action">Drill Paperwork Review</a>
    </ul>
    </p>
  <?php } ?>
</div>
<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
