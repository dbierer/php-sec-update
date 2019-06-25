<?php
/**
 * Libsodium Library Samples
 */

echo '<h1>Libsodium samples</h1>';

// Random Integer
echo '<h2>Random Integer</h2>';
echo \Sodium\randombytes_uniform(100) + 1;

// Random 16-bit integer
echo '<h2>Random 16-bit integer</h2>';
echo \Sodium\randombytes_random16();

// Hexdecimal encoding binary string
echo '<h2>Encoded hexdecimal from binary string</h2>';
$binary_string = '100101110001010';
echo "Encoded hexdecimal from binary string: $binary_string </br>";
$hex_string = \Sodium\bin2hex($binary_string);
echo $hex_string;

// Hexdecimal decoding hex to binary
echo '<h2>Hexdecimal decoding hex to binary</h2>';
echo "Decoding hexdecimal $hex_string to binary string</br>";
echo \Sodium\hex2bin($hex_string);

// Wiping sensitive data from memory
echo '<h2>Wiping sensitive data from memory</h2>';
// Using PHP 7+ random_bytes() function
//$nonce = random_bytes(32);

// OR

// Using libsodium for the nonce using your key to encrypt information
$nonce = \Sodium\randombytes_buf(\Sodium\CRYPTO_SECRETBOX_NONCEBYTES);
echo "Nonce: $nonce</br>";

// Note for stateful validation, store th nonce in the session
//$_SESSION['nonce'] = $nonce;

// Generating your encryption key
$key = \Sodium\randombytes_buf(\Sodium\CRYPTO_SECRETBOX_KEYBYTES);
echo "Encryption key: $key</br>";

$message = 'some very sensitive message';
echo "Message to encrypt: \"$message\"</br>";
$ciphertext = \Sodium\crypto_secretbox($message, $nonce, $key);
echo "Ciphertext result: $ciphertext</br>";
// Wiping the memory
\Sodium\memzero($message);
\Sodium\memzero($key);

