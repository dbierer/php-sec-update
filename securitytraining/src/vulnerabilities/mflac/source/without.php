<?php
/**
 *********************************************************************
 * PLEASE, DON'T TOUCH THIS CODE: This code is deliberately vulnerable
 * Please edit the "with.php" file fixing any vulnerabilities found
 *********************************************************************
 *
 * While this code is careful to avoid SQL Injection, the function does not
 * confirm the user sending the query is authorized to do so.
 *
 * An attacker may be able to obtain sensitive employee information from the database.
 */

function getUser($name, $config)
{
	//Use a prepared statement to avoid an SQL injection :-)
	try {
		$pdo = new PDO($config['db']['db_server'], $config['db']['db_user'], $config['db']['db_password']);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->query("SELECT last_name, password FROM users WHERE first_name = '$name'");
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		exit('<pre>' . $e->getMessage() . '</pre>');
	}

	$stmt->closeCursor();
	return $result;
}

if (isset($_GET['name'])) {
	$userRecord = getUser($_GET['name'], $this->container->get('config'));
	$html .= "Last Name: {$userRecord['last_name']} </br>";
	$html .= "Password: {$userRecord['password']} ";
}
