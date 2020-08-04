<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$cdrn = $_SESSION["cmdr_name"];
$canopy_breached = $_SESSION['canopy_breached'];
$o2t = $_SESSION['o2_timer'];
$system = $_SESSION['system'];
$platform = $_SESSION['platform'];
$hull = $_SESSION['hull'];
$synth = $_SESSION['can_synth'];

  if (isset($cdrn)) {
    $cdrn = preg_replace('/\s+/', '_', $cdrn);
    $cdrn = preg_replace('/^[@#]/i', '_', $cdrn);
    $url = 'http://3.14.187.244:3141/newcase';
    $data = array("cmdr_name" => $cdrn,
                  "canopy_breached" => $canopy_breached,
                  "o2_timer" => $o2t,
                  "system" => $system,
                  "platform" => $platform,
                  "hull" => $hull,
                  "can_synth" => $synth,
                  );

    $postdata = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);


    header("Location: https://client.hullseals.space:8443/repair.html?nick=" . $cdrn);
    exit();
  } else {
    echo "ERROR! Please contact the CyberSeals.";
    exit();
  }
  ?>
