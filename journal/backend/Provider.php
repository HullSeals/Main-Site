<?php
namespace App\Factory;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\GenericProvider;

/**
 * Created by PhpStorm.
 * User: Lars
 * Date: 30/03/2019
 * Time: 14:15
 */
class FrontierAuth
{
    private $client_id = null;
    private $client_secret = null;
    private const AUTH_API = 'https://auth.frontierstore.net';

    //changed url to work in my directory system, adjust as necessary for actual site - HW
	private const CALLBACK_URL = 'https://hullseals.space/journal/backend/Callback.php';//TODO Change to the callback of the actual application

    /**
     * FrontierAuth constructor.
     */
    public function __construct()
    {
        $json = json_decode(file_get_contents(__DIR__."../keys.json"));
        $this->client_id = $json->Client;
        $this->client_secret = $json->Secret;
    }

    /**
     * @return GenericProvider
     */
    public function create(): AbstractProvider
    {
        return new GenericProvider([
            'scope' => 'auth capi',
            'clientId' => $this->client_id,
            'clientSecret' => $this->client_secret,
            'redirectUri' => self::CALLBACK_URL,
            'urlAuthorize' => self::AUTH_API . '/auth',
            'urlAccessToken' => self::AUTH_API . '/token',
            'urlResourceOwnerDetails' => self::AUTH_API . '/me', // You may also use /me if you don't need the full JWT expiry, etc.
        ]);
    }
}
