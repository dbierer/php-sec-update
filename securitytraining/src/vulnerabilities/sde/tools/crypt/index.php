<?php
$password = 'Secret!';
$hash['DES'] = crypt($password, 'a/');
$hash['3DES'] = crypt($password, '_0099abc/');  // the value "0010" is the iteration count
$hash['MD5'] = crypt($password, '$1$abcdef12345/');
$hash['BLOWFISH'] = crypt($password, '$2a$10$abcdefghijklmnopqrstu/');
$hash['SHA256'] = crypt($password, '$5$rounds=5000$abcdefghijklmnopqrstuvwxy/');
$hash['SHA512'] = crypt($password, '$6$rounds=5000$abcdefghijklmnopqrstuvwxy/');

printf("%10s : %4s : %s\n", 'Algo', 'Size', 'Hash');
printf("%10s : %4s : %s\n", '------', '----', str_repeat('-', 64));
foreach ($hash as $key => $value)
    printf("%10s : %4d : %s\n", $key, strlen($value), $value);
