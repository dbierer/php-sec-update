<?php
/**
 * HashCat Demo
 *
 * NOTE: This demo requires use of the installed host video driver device before the code will work.
 */
define('ZEND_ROOT', '../../../../');

$passwords = [
    'Password',
    'MyAdvancedPa$$word',
    'CracKMe1444',
    'SuperPa$$wd',
    'TotallySecure#$$#$',
    'go&Ahead*Crack#Me'
];

$algo = 'md5';
$hashes = 'hashes.txt';
$output = 'cracked.txt';
$list = '/usr/share/sqlmap/txt/wordlist.txt';

foreach($passwords as $password){
    file_put_contents($hashes, $algo($password) . PHP_EOL, FILE_APPEND);
}

var_dump(shell_exec("hashcat -m 0 -a 0 $output $hashes $list"));
if(file_exists($hashes)) unlink($hashes);