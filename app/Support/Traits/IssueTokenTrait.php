<?php

namespace App\Support\Traits;

use DB;
use Illuminate\Http\Request;


trait IssueTokenTrait
{

    public function getToken(array $credentials)
    {
        $client = DB::table('oauth_clients')
            ->where('provider', '=', auth_factory('provider'))
            ->where('password_client', 1)->first();


        $token_request = Request::create(
            env("APP_URL") . '/oauth/token',
            'POST',
            [
                "grant_type" => "password",
                "username" => $credentials['email'],
                "password" => $credentials['password'],
                "client_id" => $client->id,
                "client_secret" => $client->secret,
            ]
        );

        $token_request = app()->handle($token_request);
        return json_decode($token_request->getContent(), true);
    }

    public function getRefreshToken($refresh_token)
    {
        $client = DB::table('oauth_clients')
            ->where('provider', '=', auth_factory('provider'))
            ->where('password_client', 1)->first();

        $refresh_token_request = Request::create(
            env("APP_URL") . '/oauth/token',
            'POST',
            [
                "grant_type" => "refresh_token",
                'refresh_token' => $refresh_token,
                "client_id" => $client->id,
                "client_secret" => $client->secret,
            ]
        );


        $refresh_token_request = app()->handle($refresh_token_request);

        return json_decode($refresh_token_request->getContent(), true);
    }

    public function revokeUserTokens()
    {
        $accessToken = auth_factory('user')->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
    }
}
