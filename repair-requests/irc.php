<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["cmdr_name"]))
{
  header("Location: https://hullseals.space/repair-requests/case.php");
}
$cdrn = $_SESSION["cmdr_name"];
$canopy_breached = $_SESSION['canopy_breached'];
$o2t = $_SESSION['o2_timer'];
$system = $_SESSION['system'];
$platform = $_SESSION['platform'];
$hull = $_SESSION['hull'];
$synth = $_SESSION['can_synth'];
if ($synth == 0) {
  $synthTrans = "No";
}
else {
  $synthTrans = "Yes";
}
if ($platform == 1) {
  $platformNew = "PC";
}
elseif ($platform == 2) {
  $platformNew = "Xbox";
}
elseif ($platform == 3) {
  $platformNew = "PlayStation";
}
function startsWithNumber($cdrn)
{
    return preg_match('/^\d/', $cdrn) === 1;
}
if (startsWithNumber($cdrn) == 1)
{
  $addedchar = "CMDR_";
  $cdrn = $addedchar . $cdrn;
}
function hasInvalidChars($cdrn)
{
  return preg_match("/[^a-zA-Z0-9]/", $cdrn) === 1;
}
if (hasInvalidChars($cdrn) == 1)
{
  $cdrn = preg_replace("/[^a-zA-Z0-9]/", "", $cdrn);
}
  if (isset($cdrn))
  {
    $cdrn = preg_replace('/\s+/', '_', $cdrn);
    $cdrn = preg_replace('/^[@#]/i', '_', $cdrn);
    $url = 'http://halpybot.hullseals.space:3141/newcase';
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
    $webhookurl = "";
    $timestamp = date("c", strtotime("now"));
    if ($canopy_breached == 1) {
      $json_data = json_encode([
          "content" => "New Incoming Case - <@&744998165714829334>",
          "username" => "HalpyBOT",
          "avatar_url" => "https://hullseals.space/images/emblem_mid.png",
          "tts" => false,
          "embeds" => [
              [
                  "title" => "New Code Black Case!",
                  "type" => "rich",
                  "timestamp" => $timestamp,
                  "color" => hexdec( "F5921F" ),
                  "footer" => [
                      "text" => "Hull Seals Case Notification System",
                      "icon_url" => "https://hullseals.space/images/emblem_mid.png"
                  ],
                  "fields" => [
                      [
                          "name" => "CMDR Name:",
                          "value" => $cdrn,
                          "inline" => false
                      ],
                      [
                          "name" => "Canopy Breached:",
                          "value" => "Yes",
                          "inline" => true
                      ],
                      [
                          "name" => " O2 Timer:",
                          "value" => $o2t;
                          "inline" => true
                      ],
                      [
                          "name" => "System:",
                          "value" => $system,
                          "inline" => true
                      ],
                      [
                          "name" => "Platform:",
                          "value" => $platformNew,
                          "inline" => true
                      ],
                      [
                          "name" => "Hull:",
                          "value" => $hull,
                          "inline" => true
                      ],
                      [
                          "name" => "Synth Available:",
                          "value" => $synthTrans,
                          "inline" => true
                      ]
                  ]
              ]
          ]

      ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    }
    else {
      $json_data = json_encode([
          "content" => "New Incoming Case - <@&744998165714829334>",
          "username" => "HalpyBOT",
          "avatar_url" => "https://hullseals.space/images/emblem_mid.png",
          "tts" => false,
          "embeds" => [
              [
                  "title" => "New Case!",
                  "type" => "rich",
                  "timestamp" => $timestamp,
                  "color" => hexdec( "F5921F" ),
                  "footer" => [
                      "text" => "Hull Seals Case Notification System",
                      "icon_url" => "https://hullseals.space/images/emblem_mid.png"
                  ],
                  "fields" => [
                      [
                          "name" => "CMDR Name:",
                          "value" => $cdrn,
                          "inline" => false
                      ],
                      [
                          "name" => "System:",
                          "value" => $system,
                          "inline" => true
                      ],
                      [
                          "name" => "Platform:",
                          "value" => $platformNew,
                          "inline" => true
                      ],
                      [
                          "name" => "Hull:",
                          "value" => $hull,
                          "inline" => true
                      ]
                  ]
              ]
          ]

      ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    }
$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec( $ch );
curl_close( $ch );
    header("Location: https://client.hullseals.space:8443/repair.html?nick=" . $cdrn);
    exit();
  }
else
  {
    echo "ERROR! Please contact the CyberSeals.";
    exit();
  }
  ?>
