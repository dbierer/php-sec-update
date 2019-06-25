<?php
/* This is the code file you need to modify */

if( isset( $_POST['Login'] ) ) {

	$username = $_POST['username'];
	$pass = md5($_POST['password']);
	try{
		$stmt = $this->getPdo()->query("SELECT * FROM users WHERE user='$username' AND password='$pass'");
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	}catch(PDOException $e){
		exit('<pre>' . $e->getMessage() . '</pre>');
	}

	if( $result && count($result) ) {
		// Login Successful
        $html .= "<p>Welcome to the password protected area " . $user . "</p>";
		$html .= '<img src="hackable/users/' . $result['avatar'] . '" />';
	} else {
		//Login failed
		$html .= "<pre><br>Username and/or password incorrect.</pre>";
	}
}
