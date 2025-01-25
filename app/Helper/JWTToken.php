<?php

namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Nette\Utils\Strings;

class JWTToken
{

    public static function createToken($userEmail, $userID)
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + 60 * 60 * 24 * 30,
            'userID' => $userID,
            'userEmail' => $userEmail
        ];

        return JWT::encode($payload, $key, 'HS256');
    }



    public static function createTokenForSetPassword($userEmail): string
    {

        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + 60 * 20,
            'userEmail' => $userEmail,
            'userID' => 0
        ];
        return JWT::encode($payload, $key, 'HS256');
    }
    public static function verifyToken($token)
    {

        try {

            if ($token == null) {
                return 'unauthorized';
            } else {
                $key = env('JWT_KEY');
                $decoded = JWT::decode($token, new Key($key, 'HS256'));
                return (array) $decoded;
            }
        } catch (\Exception $e) {
            return 'unauthorized';
        }
    }
}
