<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class CsrfHelper
{
    private function __construct(){}
    // Generate a CSRF token
    public static function generateToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Validate the CSRF token
    public static function validateToken($token)
    {
        if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $token) {
            return false; // Invalid token
        }
        return true; // Valid token
    }

    // Regenerate the CSRF token
    public static function regenerateToken()
    {
        unset($_SESSION['csrf_token']);
        self::generateToken();
    }
}
