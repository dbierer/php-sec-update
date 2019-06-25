<?php
/**
 * PHP Password Hash API
 */

echo "<h2>Hashing passwords</h2>";
$password = 'pa$$word12345';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Password: $password</br>";
echo "Hash: $hash</br>";

echo "<h2>Get metadata from hash</h2>";
print_r(password_get_info($hash));

echo "<h2>Password verify</h2>";
if(password_verify($password, $hash)){
	echo "Hash Verified";
} else {
	echo "Hash invalid";
}