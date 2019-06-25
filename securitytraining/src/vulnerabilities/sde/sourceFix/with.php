<?php

class User
{
	const SOME_CONSTANT = "Sensitive data";
	protected $username;
	protected $password;

	/**
	 * @param null $name
	 * @param null $pass
	 */
	public function __construct($name = null, $pass = null)
	{
		$this->username = $name;
		$this->password = $pass;
	}
}

$user  = new User();
$html  = '';
$error = '';
$valid = FALSE;

if (!empty($_POST['username']) && !empty($_POST['password'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];

    // validation
    if (!ctype_alnum($username)) {
        $error .= '<br>Your new username can only contain letters and numbers.';
        if (preg_match('/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', $password)) {
            $valid = TRUE;
        } else {
            $error .= '<br>Please make sure your password meets the following criteria:';
            $error .= '<ul>';
            $error .= '<li>At least 8 characters long</li>';
            $error .= '<li>At least 1 lowercase letter</li>';
            $error .= '<li>At least 1 UPPER case letter</li>';
            $error .= '<li>At least one special character (e.g. .-&lt;&gt;! ... etc.)</li>';
            $error .= '</ul>';
        }
    }

    if ($valid) {

        // sanitize username: strip out any non alpha-numerics
        $username = preg_replace('/[^a-z0-9]/i', '', $_POST['username']);

        // hash the password to make it ready for storage
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        //Code to check the database for existing username, we'll assume none here
        $user = new User($username, $password);

        //Call model and store user...

        $html .= "
            <div class=\"vulnerable_code_area\">
                <div>
                    <h1>Thank You for signing up for our cool service!</h1>
                    <p>We are here to help in case you need it.</p>
              </div>
             </div>";
    } else {
        $html .= "
            <div class=\"vulnerable_code_area\">
                <div>
                    <h1>Some problems were encountered when signing you up</h1>
                    <p>In order to preserve the security of your account, please fix the following, thanks!</p>
                    $error
              </div>
             </div>";
    }
}