<?php
/**
 * Zend\ACL Implementation
 */
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
$acl = new Acl();

$acl->addRole(new Role('guest'))
    ->addRole(new Role('admin'));

$acl->addResource(new Resource('runUserQuery'));

$acl->deny('guest', 'runUserQuery');
$acl->allow('admin', 'runUserQuery');

$request = new \Zend\Http\PhpEnvironment\Request();


// Simulates a model method
function runUserQuery($pdo)
{
    //Use a prepared statement to avoid an SQL injection :-)
    try {
        $stmt = $pdo->query("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        exit('<pre>' . $e->getMessage() . '</pre>');
    }
}

if($request->isGet() && $user = $request->getQuery('name')){
    //get the user and check the role
    try {
        $stmt = $this->pdo->query("SELECT last_name, role FROM users WHERE first_name = '$user'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        exit('<pre>' . $e->getMessage() . '</pre>');
    }

    if($acl->isAllowed($result['role'], "runUserQuery")){
        $userRecord = runUserQuery($this->pdo);
        foreach ($userRecord as $key => $value) {
            $html .= "$key: $value </br>";
        }
    } else {
        $html .= '<pre>NOT AUTHORIZED</pre>';
    }
}

