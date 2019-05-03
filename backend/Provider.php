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
    private const CLIENT_ID = '4e0ab7ed-0eba-44ba-b494-4a99435367b8';

    private const CLIENT_SECRET = '2dd74d80-d9e6-4625-ab64-20a38a434c63';

    private const AUTH_API = 'https://auth.frontierstore.net';

    //changed url to work in my directory system, adjust as necessary for actual site - HW
	private const CALLBACK_URL = 'http://development.localhost/journal-reader/backend/Callback.php'; //TODO Change to the callback of the actual application

    /**
     * @return GenericProvider
     */
    public function create(): AbstractProvider
    {
        return new GenericProvider([
            'scope' => 'auth capi',
            'clientId' => self::CLIENT_ID,
            'clientSecret' => self::CLIENT_SECRET,
            'redirectUri' => self::CALLBACK_URL,
            'urlAuthorize' => self::AUTH_API . '/auth',
            'urlAccessToken' => self::AUTH_API . '/token',
            'urlResourceOwnerDetails' => self::AUTH_API . '/me', // You may also use /me if you don't need the full JWT expiry, etc.
        ]);
    }
}