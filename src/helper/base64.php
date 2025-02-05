<?php

class Base64IdHelper
{
    /**
     * Encode the given ID using Base64.
     * @param int $id
     * @return string
     */
    public static function encode_id(int $id): string
    {
        return base64_encode((string)$id);
    }

    /**
     * Decode the given Base64-encoded ID.
     * @param string $encodedId
     * @return int|null
     */
    public static function decode_id(string $encodedId): ?int
    {
        $decoded = base64_decode($encodedId, true);
        return is_numeric($decoded) ? (int)$decoded : null;
    }

    /**
     * Safely encode an ID for use in URLs and HTML.
     * @param int $id
     * @return string
     */
    public static function safe_encode_id(int $id): string
    {
        return htmlspecialchars(urlencode(self::encode_id($id)), ENT_QUOTES, 'UTF-8');
    }
}

