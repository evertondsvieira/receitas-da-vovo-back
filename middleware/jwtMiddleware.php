<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/jwt.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/jwt.php';

class JwtMiddleware
{
    public static function handle()
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            exit(json_encode(['error' => 'Authorization header not found']));
        }

        $jwt = str_replace('Bearer ', '', $headers['Authorization']);

        try {
            $decodedJwt = Jwt::decode($jwt);
        } catch (Exception $e) {
            http_response_code(401);
            exit(json_encode(['error' => $e->getMessage()]));
        }

        $user = User::find($decodedJwt->sub);

        if (!$user) {
            http_response_code(401);
            exit(json_encode(['error' => 'Invalid user']));
        }
    }
}
