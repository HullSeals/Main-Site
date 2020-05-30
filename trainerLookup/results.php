<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once '../users/init.php';  //make sure this path is correct!
if (!securePage($_SERVER['PHP_SELF'])){die();}
error_reporting(E_ALL);
$counter = 0;
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Seal Search Results</title>
   </head>
   <body>
     <form action="index.php">
         <button type="submit">Go Back</button>
      </form>
    </body>
</html>
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = include 'db.php';
$mysqli = new mysqli($db['server'], $db['user'], $db['pass'], $db['db'], $db['port']);
$stmt = $mysqli->prepare("SELECT c.*, hull_stat, o2_synth, status_name, color_name, ca.dispatch, notes
FROM cases AS c
    INNER JOIN case_seal AS cs ON cs.case_ID = c.case_ID
    INNER JOIN case_history AS ch ON ch.case_ID = c.case_ID
    INNER JOIN case_assigned AS ca ON ca.case_ID = c.case_ID
    INNER JOIN lookups.status_lu AS sl ON sl.status_ID = ch.case_stat
    INNER JOIN lookups.case_color_lu AS cl ON cl.color_id = ch.code_color
    INNER JOIN sealsudb.staff AS ss ON ss.seal_id = ca.seal_kf_id
WHERE seal_name = ? AND case_stat = 2");
$stmt->bind_param("s", $_POST['seal_name']);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) exit('No Rescues');
echo "Returning all Successful Cases for: ";
echo $_POST['seal_name'];
echo nl2br ("\n");
echo '<table border="5" cellspacing="2" cellpadding="2">
      <tr>
          <td> <font face="Arial">Case ID</font> </td>
          <td> <font face="Arial">Case Date</font> </td>
          <td> <font face="Arial">Dispatcher? (1=Yes, 0=No)</font> </td>
      </tr>';
    while ($row = $result->fetch_assoc()) {
        $field1name = $row["case_ID"];
        $field2name = $row["case_created"];
        $field3name = $row["dispatch"];
        echo '<tr>
                  <td>'.$field1name.'</td>
                  <td>'.$field2name.'</td>
                  <td>'.$field3name.'</td>
              </tr>';
          $counter++;
    }
    $result->free();
    echo "Number of records: ";
    echo $counter;
    echo nl2br ("\n");

?>
