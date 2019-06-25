<?php
use Zend\Http\Header\MaxForwards;

/**
 * A Secure Version Script
 *
 * Note: This is a limited secure version, not a complete one.
 * Please add access control (ACL) for query authorization.
 */
define('MAX_ATTEMPTS', 4);
define('REDIRECT_URL', 'http://securitytraining/');
// session based page count
if (!session_status() == PHP_SESSION_ACTIVE) {
    session_start();
}
// unpredictable outputs
$messages = ['Unable to login', 
            'Username / password incorrect', 
            'Please try again', 
            'Have a great day', 
            'Where is that yellow sticky note with your password?'
];
$html .= '<pre>';
if( isset( $_POST[ 'Login' ] ) ) {

    // init variables
    $result = NULL;
    $login  = FALSE;
    $hashFromDb = '';
    
	// Sanitise username input
	$user = ctype_alnum($_POST['username']) ? $_POST['username'] : null;

	// Sanitise password input
	$pass = $_POST[ 'password' ] ?? NULL;

	// Hit count
	$_SESSION['login_attempts'] = $_SESSION['login_attempts'] ?? 0;
	$_SESSION['login_attempts']++;
	
	if ($user && $pass){
		try{
			$pdo =$this->zendDatabaseConnect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $pdo->prepare('SELECT * FROM users WHERE username=?');
			$stmt->execute([$user]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$hashFromDb = $result['password'] ?? '';
		} catch (PDOException $e) {
        	error_log(__FILE__ . ':' . $e->getMessage());
		    $html .= 'Unable to obtain login information' . PHP_EOL;
		}

		if( $result && password_verify($pass, $hashFromDb)) {
			// Login Successful
			$html .= '<p>Welcome to the password protected area ' . $result['first_name'] . ' ' . $result['last_name'] . '</p>';
			$html .= '<img src="' . htmlspecialchars($result['avatar']) . '" />';
			$login = TRUE;
		} else {
			//Login failed
			$html .= $messages[rand(0,count($messages) - 1)] . PHP_EOL;
		}
	} else {
		$html .= 'Invalid input';
	}
    // redirect if login attempts exceeds max
    if (!$login && $_SESSION['login_attempts'] > MAX_ATTEMPTS) {
        $html .= 'Normally a redirect to <b>' . REDIRECT_URL . '</b> would occur at this point!!!';
        $_SESSION['login_attempts'] = 1;
    }
}
$html .= '</pre>';
