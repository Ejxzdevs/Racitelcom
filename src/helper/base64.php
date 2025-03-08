<?php
require __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Set encryption key from environment variable
EncryptionHelper::setKey(getenv('AES_SECRET_KEY'));

class EncryptionHelper
{
    // Private static encryption key
    private static $key;

    // AES encryption method and block size
    private static $method = 'aes-256-cbc';
    private static $ivLength = 16;

    /**
     * Set the encryption key
     *
     * @param string $key
     */
    public static function setKey(string $key)
    {
        self::$key = $key;
    }

    /**
     * Get the current encryption key
     *
     * @return string The encryption key
     */
    public static function getKey(): string
    {
        return self::$key;
    }

    /**
     * Encrypt an array of data and return a Base64-encoded string
     *
     * @param array $data Data to be encrypted
     * @return string Base64-encoded encrypted data with IV
     */
    public static function encryptArrayData(array $data): string
    {
        // Serialize the data array
        $serializedData = serialize($data);

        // Generate a random initialization vector (IV)
        $iv = random_bytes(self::$ivLength);  // AES-256-CBC requires a 16-byte IV

        // Encrypt the data using AES-256-CBC
        $encryptedData = openssl_encrypt($serializedData, self::$method, self::$key, 0, $iv);

        // Combine the IV and encrypted data, then Base64 encode
        return base64_encode($iv . $encryptedData);
    }

    /**
     * Decrypt a Base64-encoded string and return the original array
     *
     * @param string $encodedData Base64-encoded encrypted data
     * @return array|null Decrypted array data or null if decryption fails
     */
    public static function decryptArrayData(string $encodedData): ?array
    {
        // Decode the Base64-encoded data
        $ivAndEncryptedData = base64_decode($encodedData);

        // Check if the data is valid (IV length must be correct)
        if (strlen($ivAndEncryptedData) < self::$ivLength) {
            return null;
        }

        // Extract the IV and encrypted data
        $iv = substr($ivAndEncryptedData, 0, self::$ivLength);
        $encryptedData = substr($ivAndEncryptedData, self::$ivLength);

        // Decrypt the data using AES-256-CBC with the extracted IV
        $decryptedData = openssl_decrypt($encryptedData, self::$method, self::$key, 0, $iv);

        // Return the unserialized data or null if decryption failed
        return $decryptedData === false ? null : unserialize($decryptedData);
    }
}
