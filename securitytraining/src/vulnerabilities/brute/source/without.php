<?php
/**
 *********************************************************************
 * PLEASE, DON'T TOUCH THIS CODE: This code is deliberately vulnerable
 * Please edit the "with.php" file fixing any vulnerabilities found
 *********************************************************************
 */

if( isset( $_POST['Login'] ) ) {

	$username = $_POST['username'];
	$pass = md5($_POST['password']);
	try{
		$stmt = $this->getPdo()->query("SELECT * FROM users WHERE username='$username' AND password='$pass'");
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	}catch(PDOException $e){
		exit('<pre>' . $e->getMessage() . '</pre>');
	}

	if( $result && count($result) ) {
		// Login Successful
		$html .= "<p>Welcome to the password protected area <b>$username</b> </p>";
		$html .= '<img src="' . $result['avatar'] . '" />';
	} else {
		//Login failed
		$html .= "<pre><br>Username and/or password incorrect.</pre>";
	}
}