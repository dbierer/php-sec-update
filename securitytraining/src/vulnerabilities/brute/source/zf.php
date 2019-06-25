<?php
/**
 * A Secure ZF Version
 *
 */
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

$username = new Input("username");
$username->getFilterChain()->attachByName('StringTrim')->attachByName('StripTags');

$password = new Input("password");
$password->getFilterChain()->attachByName('StringTrim');

$inputFilter = new InputFilter();
$inputFilter->add($username, "username");
$inputFilter->add($password, "password");

if (isset($_POST['Login'])) {

    // Sanitise username input
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $inputFilter->setData(array("password" => $pass, 'username' => $username));

    //Code to authorize access...
    if($inputFilter->isValid()){
        $user = $inputFilter->getValue('username');
        $pass = $inputFilter->getValue('password');
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        // Authenticate user
        try {
            $resultSet = $this->adapter->query("SELECT * FROM users WHERE username='$user'", $this->adapter::QUERY_MODE_EXECUTE);
            $result = current($resultSet->toArray());
            if(count($result) &&
                password_verify($pass, $hash)){
                //Login successful user authenticated
                $html .= "<p>Welcome to the password protected area " . $user . "</p>";
                $html .= '<img src="hackable/users/' . htmlspecialchars($result['avatar']) . '" />';

            }else{
                throw new PDOException('User invalid');
            };
        } catch (PDOException $e) {
            // Log exception
            $html .= "<pre>Invalid input</pre>";
        }
    }
} else {
    $html .= "<pre>Invalid input</pre>";
}
