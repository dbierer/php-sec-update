<?php
$password = 'Secret!';  // this is what we want to hash
$algos    = ['md5','sha256','sha512','sha3-512','ripemd256','tiger192,4','snefru256','gost-crypto','haval256,5'];
$key      = base64_encode(random_bytes(8));

printf("%11s : %4s : %s\n", 'Algo', 'Size', 'Hash');
printf("%11s : %4s : %s\n", '------', '----', str_repeat('-', 64));
foreach ($algos as $algo) {
    $hash = hash_hmac($algo, $password, $key);
    printf("%11s : %4d : %s\n", $algo, strlen($hash), $hash);
}

echo PHP_EOL;
echo implode(':', hash_hmac_algos());
