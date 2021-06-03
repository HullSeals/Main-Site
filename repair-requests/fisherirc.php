<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["cmdr_name"]))
{
  header("Location: https://hullseals.space/repair-requests/case.php");
}
//Authenticaton Info
$auth = require 'auth.php';
$secret = $auth['auth'];
$key = $auth['key'];
$webhookurl = $auth['discord'];
$url = $auth['url'];
$auth = hash_hmac('sha256', $key, $secret);
//Case Info
$cdrn = $_SESSION['cmdr_name'];
$truecdrn = $cdrn;
$system = $_SESSION['system'];
$planet = $_SESSION['planet'];
$platform = $_SESSION['platform'];
$curr_cord = $_SESSION['curr_coord'];
$case_type = $_SESSION['case_type'];
//Platform Logic - TODO: replace with API.
if ($platform == 1) {
  $platformNew = "PC - Odyssey";
}
elseif ($platform == 2) {
  $platformNew = "Xbox";
}
elseif ($platform == 3) {
  $platformNew = "PlayStation";
}
elseif ($platform == 4) {
  $platformNew = "PC - Horizons";
}
//Case Type
if ($case_type == 8) {
  $typeNew = "Lift";
}
elseif ($case_type == 9) {
  $typeNew = "Golf";
}
elseif ($case_type == 10) {
  $typeNew = "Puck";
}
elseif ($case_type == 11) {
  $typeNew = "Pick";
}
//Rename CMDR as needed
function startsWithNumber($cdrn)
{
    return preg_match('/^\d/', $cdrn) === 1;
}
//catch numbers
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
//All that done, start formatting message.
  if (isset($cdrn))
  {
    //IRC notif
    $data = [
      "type" => "KFCASE",
    	"parameters" => [
    		"Platform" => $platformNew,
    		"CMDR" => $cdrn,
    		"System" => $system,
    		"KFType" => $typeNew,
    		"Planet" => $planet,
    	"Coords" => $curr_cord
        ]
      ];
      $postdata = json_encode($data);
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'hmac: '. $auth
      ));
      $result = curl_exec($ch);
      curl_close($ch);

//Discord Notif
    $timestamp = date("c", strtotime("now"));
    $json_data = json_encode([
        "content" => "New Incoming Case - <@&744998165714829334>",
        "username" => "HalpyBOT",
        "avatar_url" => "https://hullseals.space/images/emblem_mid.png",
        "tts" => false,
        "embeds" => [
            [
                "title" => "New Kingfisher Case!",
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
                        "value" => $truecdrn,
                        "inline" => false
                    ],
                    [
                        "name" => "IRC Name:",
                        "value" => $cdrn,
                        "inline" => false
                    ],
                    [
                        "name" => "System:",
                        "value" => $system,
                        "inline" => true
                    ],
                    [
                        "name" => "Planet:",
                        "value" => $planet,
                        "inline" => true
                    ],
                    [
                        "name" => "Platform:",
                        "value" => $platformNew,
                        "inline" => true
                    ],
                    [
                        "name" => "Coordinates:",
                        "value" => $curr_cord,
                        "inline" => true
                    ],
                    [
                        "name" => "Type:",
                        "value" => $typeNew,
                        "inline" => true
                    ]
                ]
            ]
        ]

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    $ch = curl_init( $webhookurl );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec( $ch );
    curl_close( $ch );

    //Send Client to Case Form
    $cdrn = preg_replace('/\s+/', '_', $cdrn);
    $cdrn = preg_replace('/^[@#]/i', '_', $cdrn);
    header("Location: https://client.hullseals.space:8443/repair.html?nick=" . $cdrn);
    exit();
  }
  else
  {
    echo "ERROR! Please contact the CyberSeals.";
    exit();
  }
  ?>
