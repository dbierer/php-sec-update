<?php
/*
 * This is the code file you need to modify
 *
 * While this code is careful to avoid SQL Injection, the function does not
 * confirm the user sending the query is authorized to do so.
 *
 * An attacker may be able to obtain sensitive employee information from the database.
 */

if (isset($_REQUEST['name'])) {
    $username = $_REQUEST['name'];
    try {
        $stmt = $this->getPdo()->prepare("SELECT first_name, last_name, password FROM users WHERE first_name = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log(date('Ymd') . '|' . $e->getMessage() . PHP_EOL, 3, '../' . FrontController::LOG);
        exit;
    }
	$html .= "First Name: {$result['first_name']} </br>";
	$html .= "Last Name: {$result['last_name']} </br>";
	$html .= "Password: {$result['password']} ";
}
