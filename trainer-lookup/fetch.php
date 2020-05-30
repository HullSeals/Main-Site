<?php
//UserSpice Required
require_once '../users/init.php';
//fetch.php;
define ('DB_USER', "");
define ('DB_PASSWORD', "");
define ('DB_DATABASE', "");
define ('DB_HOST', "");

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	$sql = "SELECT seal_name, seal_id FROM staff
			WHERE (seal_name LIKE '%".$_GET['query']."%') AND (seal_name <> 'Null') AND (seal_id <> 0)
      ORDER BY seal_name ASC
			LIMIT 10";

	$result = $mysqli->query($sql);

	$json = [];
	while($row = $result->fetch_assoc()){
	     $json[] = $row['seal_name'];
	}
	echo json_encode($json);
?>
