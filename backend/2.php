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
//    echo 'Access Token: ' . $accessToken->getToken() . "<br>";
//    echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
//    echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
//    echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";

    // Using the access token, we may look up details about the
    // resource owner.
    $_SESSION['accessToken'] = $accessToken->getToken();
    $resourceOwner = $provider->getResourceOwner($accessToken);
    header("Location: 3.php");
    //var_export($resourceOwner->toArray());
} catch (IdentityProviderException $e) {
}


