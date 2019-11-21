<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 30/03/2019
 * Time: 13:43
 */

use App\Factory\FrontierAuth;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;

require '../vendor/autoload.php';
require 'Provider.php';
session_start();
/* @var $provider GenericProvider */
$factory = new FrontierAuth();
$provider = $factory->create();
try {
    if (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])){
        if (isset($_SESSION['oauth2state'])){
            unset($_SESSION['oauth2state']);
        }
    }
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);
    $resourceOwner = $provider->getResourceOwner($accessToken);
    $auth = "Authorization: Bearer ".$accessToken->getToken();
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
    $codeBlack = ($codeBlack) ? 'true' : 'false';
    $_SESSION['debug'] = $json;
    $journalch = curl_init();
    curl_setopt($journalch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($journalch,CURLOPT_URL,"https://companion.orerve.net/journal");
    curl_setopt($journalch, CURLOPT_HTTPHEADER,array(
        $auth
    ));
    $journalresult = curl_exec($journalch);
    $journallines = explode("\n", $journalresult);
    $cleaned = "";
    foreach ($journallines as $line) {
        if (strlen($line)!=0){
            $cleaned .= $line.",";
        }
    }
    $cleanedjson = '['.str_slice($cleaned,0,-1).']';
    $journaljson = json_decode($cleanedjson);
    $iron = 0;
    $nickel = 0;
    $lifesupport = 0;
    foreach ($journaljson as $index => $data){
        if ($data->event == "Materials"){
            foreach ($data->Raw as $i => $material){
                if ($material->Name == "iron"){
                    $iron = $material->Count;
                }elseif ($material->Name == "nickel"){
                    $nickel = $material->Count;
                }
            }
        }
    }
    $iron = floor($iron/2);
    if ($iron<$nickel){
        $lifesupport = $iron;
    }elseif ($iron>$nickel){
        $lifesupport = $nickel;
    }
    $_SESSION['info'] = array(
        "system" => $json->lastSystem->name,
        "hull" => $hull,
        "breach" => $codeBlack,
        "oxygen" => $oxygen,
        "shiptype" => $json->ship->name,
        "lifesupport" => $lifesupport
    );
    //TODO IRC/web hook
    header("Location: ../result.php");
} catch (IdentityProviderException $e) {
}
function str_slice($str, $start, $end = FALSE)
{
    $max = strlen($str);
    $start = ($start<0)? $max+$start : $start;
    $end = ($end<0)? $max+$end : (($end === FALSE)? $max : $end);
    $slice = substr($str, $start, ($end>$start)? $end-$start : 0);
    return ($slice === FALSE)? '' : $slice;
}

