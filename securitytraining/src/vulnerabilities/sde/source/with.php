<?php
/* This is the code file you need to modify */
$html = '';

if (!empty($_POST['username']) && !empty($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	//Code to check the database for existing username, we'll assume none here

	$user = new \src\vulnerabilities\sde\source\User($username, $password);

	//Call model and store the entity...

	$html .= "
		<br>
        <div class=\"vulnerable_code_area\">
            <div>
	            <h1>Thank You for signing up for our cool service $username!</h1>
			    <p>We are here to help if needed.</p>
		  </div>
		 </div>";
}
