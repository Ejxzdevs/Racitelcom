<?php
class EncryptionHelper
{
    // Encryption key and method
    private static $key = 'dsdsadddddddddddweq12321';  // Make sure to store this securely
    private static $method = 'aes-256-cbc'; // AES encryption method
    private static $ivLength = 16;  // AES block size for CBC

    /**
     * Encrypt an array of data and return a Base64-encoded encrypted string.
     * @param array $data The array of data to encrypt
     * @return string The Base64-encoded encrypted data
     */
    public static function encryptArrayData(array $data): string
    {
        // 1. Serialize the array into a string
        $serializedData = serialize($data);

        // 2. Generate a random Initialization Vector (IV)
        $iv = random_bytes(self::$ivLength);  // AES-256-CBC requires a 16-byte IV

        // 3. Encrypt the serialized data using AES-256-CBC
        $encryptedData = openssl_encrypt($serializedData, self::$method, self::$key, 0, $iv);

        // 4. Combine the IV and encrypted data (Base64 encode both)
        $ivAndEncryptedData = base64_encode($iv . $encryptedData);

        // Return the final Base64-encoded encrypted data
        return $ivAndEncryptedData;
    }

    /**
     * Decrypt the encrypted Base64 data and return the original array.
     * @param string $encodedData The Base64-encoded encrypted data
     * @return array|null The decrypted data as an array, or null if decryption fails
     */
    public static function decryptArrayData(string $encodedData): ?array
    {
        // URL decode the Base64 encoded data
        $ivAndEncryptedData = base64_decode($encodedData);

        // Check if the data is valid
        if (strlen($ivAndEncryptedData) < self::$ivLength) {
            return null;  // Invalid data
        }

        // Extract the IV and the encrypted data (the IV is the first 16 bytes)
        $iv = substr($ivAndEncryptedData, 0, self::$ivLength);
        $encryptedData = substr($ivAndEncryptedData, self::$ivLength);

        // 5. Decrypt the data using AES-256-CBC and the same IV
        $decryptedData = openssl_decrypt($encryptedData, self::$method, self::$key, 0, $iv);

        // Check if decryption was successful
        if ($decryptedData === false) {
            return null;  // Decryption failed
        }

        // 6. Unserialize the decrypted data to convert it back to an array
        return unserialize($decryptedData);
    }
}

