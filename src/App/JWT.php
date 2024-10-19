<?php

declare(strict_types=1);

namespace App;

class JWT
{
    private static $secret;
    public function __construct(string $secret)
    {
        self::$secret = $secret;
    }
    // Create a JWT
    public static function createToken(array $payload, int $expiry): string
    {
        // Header: specify the type and algorithm
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        // Add expiration time to the payload
        $payload['exp'] = time() + $expiry;

        // Encode the header and payload as base64 strings
        $base64Header = self::base64UrlEncode(json_encode($header));
        $base64Payload = self::base64UrlEncode(json_encode($payload));

        // Create the signature using HMAC SHA256 and the secret key
        $signature = hash_hmac('sha256', "$base64Header.$base64Payload", self::$secret, true);
        $base64Signature = self::base64UrlEncode($signature);

        // Return the JWT: header.payload.signature
        return "$base64Header.$base64Payload.$base64Signature";
    }

    // Validate a JWT and return the decoded payload if valid
    public static function validateToken(string $token): ?array
    {
        // Split the token into its three parts: header, payload, and signature
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;  // Invalid token structure
        }

        [$base64Header, $base64Payload, $base64Signature] = $parts;

        // Recreate the signature using the header and payload
        $signature = hash_hmac('sha256', "$base64Header.$base64Payload", self::$secret, true);
        $expectedSignature = self::base64UrlEncode($signature);

        // Compare the signatures
        if (!hash_equals($expectedSignature, $base64Signature)) {
            return null;  // Invalid signature
        }

        // Decode the payload
        $payload = json_decode(self::base64UrlDecode($base64Payload), true);

        // Check if the token has expired
        if ($payload['exp'] < time()) {
            return null;  // Token has expired
        }

        // Token is valid
        return $payload;
    }

    // Helper function to encode using base64Url (URL-safe base64)
    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    // Helper function to decode base64Url
    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    // Generate 32 bytes (256 bits) of random data then Convert the binary data to a hexadecimal representation
    // to help generate the $secret key for JWT.
    public static function generate256BitKey(): string
    {
        $bytes = random_bytes(32);
        return bin2hex($bytes);
    }
}
