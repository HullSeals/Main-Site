<?php
/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 30/03/2019
 * Time: 13:38
 */
require '../vendor/autoload.php';
require 'Provider.php';
use League\OAuth2\Client\Provider\GenericProvider;
use App\Factory\FrontierAuth;
session_start();
$factory = new FrontierAuth();
$provider = $factory->create();

// If we don't have an authorization code then get one

// Fetch the authorization URL from the provider; this returns the
// urlAuthorize option and generates and applies any necessary parameters
// (e.g. state).
$authorizationUrl = $provider->getAuthorizationUrl();

// Get the state generated for you and store it to the session.
$_SESSION['oauth2state'] = $provider->getState();
// Redirect the user to the authorization URL.
header('Location: ' . $authorizationUrl);
exit;