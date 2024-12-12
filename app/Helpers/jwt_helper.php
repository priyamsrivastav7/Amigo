<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function generate_jwt($data)
{
    $expiration_time_in_seconds = 3600;
    $key = getenv('JWT_SECRET_KEY');
    $issuedAt = time();
    $payload['iat'] = $issuedAt;
    $payload['exp'] = $issuedAt + $expiration_time_in_seconds;
    $payload['data'] = $data;

    return JWT::encode($payload, $key, 'HS256');
}

function validate_jwt($token)
{
    $key = getenv('JWT_SECRET_KEY'); // Ensure this is correctly set in your environment
    try {
        $decoded = JWT::decode($token, new Key($key, 'HS256')); // Use the Key class
        if ($decoded->exp < time()) {
            return null; // Token expired
        }
        return $decoded;
    } catch (Exception $e) {
        return null; // Invalid token
    }
}


function get_authorization_header()
{
    $headers = getallheaders();
    return isset($headers['Authorization']) ? trim(str_replace('Bearer ', '', $headers['Authorization'])) : null;
}
