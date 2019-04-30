<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 30/03/2019
 * Time: 13:43
 */

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

require '../vendor/autoload.php';
require 'Provider.php';
session_start();
/* @var $provider \League\OAuth2\Client\Provider\GenericProvider */
$factory = new \App\Factory\FrontierAuth();
$provider = $factory->create();
try {
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

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
    $_SESSION['info'] = array(
        "system" => $json->lastSystem->name,
        "hull" => $hull,
        "breach" => $codeBlack,
        "oxygen" => $oxygen,
        "shiptype" => $json->ship->name
    );
    $_SESSION['debug'] = $json;
    //TODO IRC/web hook
    header("Location: ../result.php");
} catch (IdentityProviderException $e) {
}


