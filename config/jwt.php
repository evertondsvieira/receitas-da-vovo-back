<?php

class JWT
{
    private static $secret_key = 'EbEbYff4EX';
    private static $encrypt = ['HS256'];
    private static $aud = null;

    public static function encode($data)
    {
        $header = [
            'typ' => 'JWT',
            'alg' => self::$encrypt[0]
        ];

        $payload = $data;
        $payload['exp'] = time() + (60 * 60 * 24);

        $jwt = JWT::urlsafeB64Encode(json_encode($header)) . '.' . JWT::urlsafeB64Encode(json_encode($payload));
        $jwt .= '.' . JWT::signature($jwt, self::$secret_key, self::$encrypt[0]);

        return $jwt;
    }

    public static function decode($jwt)
    {
        $jwt_parts = explode('.', $jwt);

        if (count($jwt_parts) == 3) {
            $signature = JWT::signature($jwt_parts[0] . '.' . $jwt_parts[1], self::$secret_key, self::$encrypt[0]);

            if ($signature == $jwt_parts[2]) {
                $payload = json_decode(JWT::urlsafeB64Decode($jwt_parts[1]), true);

                if ($payload['exp'] < time()) {
                    return null;
                }

                if (self::$aud !== null && isset($payload['aud']) && $payload['aud'] !== self::$aud) {
                    return null;
                }

                return $payload;
            }
        }

        return null;
    }

    private static function signature($input, $key, $alg)
    {
        $alg_config = array(
            'HS256' => 'sha256'
        );

        return JWT::urlsafeB64Encode(hash_hmac($alg_config[$alg], $input, $key, true));
    }

    private static function urlsafeB64Encode($input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    private static function urlsafeB64Decode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $addlen = 4 - $remainder;
            $input .= str_repeat('=', $addlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }
}