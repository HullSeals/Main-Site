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
$key = $auth['key'];
$constant = $auth['constant'];
$webhookurl = $auth['discord'];
$url = $auth['url'];
//Case Info
$cdrn = $_SESSION["cmdr_name"];
$truecdrn = $cdrn;
$canopy_breached = $_SESSION['canopy_breached'];
$o2t = $_SESSION['o2_timer'];
$system = $_SESSION['system'];
$platform = $_SESSION['platform'];
$hull = $_SESSION['hull'];
$synth = $_SESSION['can_synth'];
//Synth Status
if ($synth == 1) {
  $synthTrans = "No";
}
else {
  $synthTrans = "Yes";
}

//DB stuff
$db = include 'db.php';
$mysqli = new mysqli($db['server'], $db['user'], $db['pass'], $db['db'], $db['port']);
$platformList = [];
$res = $mysqli->query('SELECT * FROM lookups.platform_lu ORDER BY platform_id');
while ($row = $res->fetch_assoc()) {
    if ($row['platform_name'] == 'ERR') {
        continue;
    }
    $platformList[$row['platform_id']] = $row['platform_name'];
}

$platformNew = $platformList[$platform];

//Canopy Status
if ($canopy_breached == 1) {
	$image = "https://hullseals.space/images/CodeBlack.png";
}
elseif (($hull <= 100) && (50 <= $hull)) {
	$image = "https://hullseals.space/images/CodeGreen.png";
}
elseif (($hull <= 49) && (11 <= $hull)) {
	$image = "https://hullseals.space/images/CodeAmber.png";
}
else {
	$image = "https://hullseals.space/images/CodeRed.png";
}
//Rename CMDR as needed
function startsWithNumber($cdrn)
{
    return preg_match('/^\d/', $cdrn) === 1;
}
//Catch Numbers
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
    //IRC Notif
    if ($canopy_breached == 1) {
      $data = [
	        "type" => "CODEBLACK",
	        "parameters" => [
		        "Platform" => $platformNew,
		        "CMDR" => $cdrn,
		        "System" => $system,
		        "Hull" => $hull,
		        "CanSynth" => $synthTrans,
		        "Oxygen" => $o2t
          ]
		    ];
        $postdata = json_encode($data);
        $hmacdata = preg_replace("/\s+/", "", $postdata);
        $auth = hash_hmac('sha256', $hmacdata, $key);
        $keyCheck = hash_hmac('sha256', $constant, $key);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
	        'hmac: '. $auth,
          'keyCheck: '. $keyCheck
        ));
        $result = curl_exec($ch);
        curl_close($ch);
      }
    else {
      $data = [
	        "type" => "SEALCASE",
	        "parameters" => [
		        "Platform" => $platformNew,
		        "CMDR" => $cdrn,
		        "System" => $system,
		        "Hull" => $hull,
          ]
		    ];
        $postdata = json_encode($data);
        $hmacdata = preg_replace("/\s+/", "", $postdata);
        $auth = hash_hmac('sha256', $hmacdata, $key);
        $keyCheck = hash_hmac('sha256', $constant, $key);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'hmac: '. $auth,
          'keyCheck: '. $keyCheck
        ));
        $result = curl_exec($ch);
        curl_close($ch);    }

    //Discord Notif
    $timestamp = date("c", strtotime("now"));
    //FOR CB
    if ($canopy_breached == 1) {
      $json_data = json_encode([
          "content" => "New Incoming Case - <@&591822215238909966>",
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
                          "value" => $truecdrn,
                          "inline" => false
                      ],
                      [
                          "name" => "IRC Name:",
                          "value" => $cdrn,
                          "inline" => true
                      ],
                      [
                          "name" => "Canopy Breached:",
                          "value" => "Yes",
                          "inline" => true
                      ],
                      [
                          "name" => " O2 Timer:",
                          "value" => $o2t,
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
      //FOR STANDARD CASE
      $json_data = json_encode([
          "content" => "New Incoming Case - <@&591822215238909966>",
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
                          "value" => $truecdrn,
                          "inline" => false
                      ],
                      [
                          "name" => "IRC Name:",
                          "value" => $cdrn,
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
//First Message Done, now send Color.
      $json_data = json_encode([
	  "content" => $image,
	  "username" => "HalpyBOT",
          "avatar_url" => "https://hullseals.space/images/emblem_mid.png",
          "tts" => false,
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

//Send Client to case form
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
