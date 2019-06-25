<?php
/**
 * User.php
 */
namespace src\vulnerabilities\sde\source;
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