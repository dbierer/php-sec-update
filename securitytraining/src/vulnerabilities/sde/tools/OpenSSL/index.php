<?php
$message  = 'Credit card number: 4444-1111-2222-3333';
$password = 'Secret!';
$iv       = base64_encode(random_bytes(16));
$authTag  = '';
$cipher   = openssl_encrypt($message, 'aes-256-gcm', $password,  OPENSSL_ZERO_PADDING, $iv, $authTag);
echo 'Auth Tag      : ' . bin2hex($authTag) . PHP_EOL;
echo 'Cipher Text   : ' . $cipher . PHP_EOL;
echo 'Original Text : ' . openssl_decrypt($cipher, 'aes-256-gcm', $password,  OPENSSL_ZERO_PADDING, $iv, $authTag);
echo PHP_EOL;
echo implode(', ', openssl_get_cipher_methods());