<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 30/03/2019
 * Time: 14:33
 */
session_start();
$auth = "Authorization: Bearer ".$_SESSION['accessToken'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_URL,"https://companion.orerve.net/profile");
curl_setopt($ch, CURLOPT_HTTPHEADER,array(
    $auth
));
$result = curl_exec($ch);
$json = json_decode($result);
$hull = $json->ship->health->hull;
$hull = $hull/10000;
$oxygen = $json->ship->oxygenRemaining/60000;
$codeBlack = $json->ship->cockpitBreached;
if ($codeBlack){
    echo $codeBlack;
    echo $json->ship->oxygenRemaining;
}
$codeBlack = ($codeBlack) ? 'true' : 'false';
$_SESSION['info'] = array(
    "system" => $json->lastSystem->name,
    "hull" => $hull,
    "breach" => $codeBlack,
    "oxygen" => $oxygen,
    "shiptype" => $json->ship->name
);
$_SESSION['debug'] = $json;
//echo($result);
//$hook = curl_init();
//curl_setopt($hook, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($hook, CURLOPT_URL, "http://rocketchat.larsdormans.ga/hooks/c5G4zGTzKi9j7AWJn/Em8oKF46GxKhfFvan6DAJuxxaqz5mjLkGrr5TAHR2Qp6f8dB");
//curl_setopt($hook, CURLOPT_HTTPHEADER, array(
//    'Content-Type: application/json'
//));
//curl_setopt($hook,CURLOPT_POST, 1);
//$postData = '{"text":"Tracker result","attachments":[{"title":"CMDR '.$json->commander->name.'","text":"Location: '.$json->lastSystem->name.' \n Hull: '.$hull.'% \n Breach: '.$codeBlack.' \n Oxygen: '.$oxygen.' Minutes \n Ship: '.$json->ship->name.'"}]}';
//curl_setopt($hook, CURLOPT_POSTFIELDS, $postData);
//$hookcallback = curl_exec($hook);
//var_dump($hookcallback);
header("Location: ../result.php");
