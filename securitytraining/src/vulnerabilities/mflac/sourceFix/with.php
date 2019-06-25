<?php
//Code to authenticate and authorize access...

function getUser($name, $config)
{
	try {
		$pdo = new PDO($config['db']['db_server'], $config['db']['db_user'], $config['db']['db_password']);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("SELECT role FROM users WHERE first_name = ?");
		$stmt->execute([$name]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		exit('<pre>' . $e->getMessage() . '</pre>');
	}

	$stmt->closeCursor();
	return $result;
}
function getAcl()
{
    $acl = ['getUser' => ['admin' => 1,'guest' => 0],
            'getSomething' => ['admin' => 1, 'guest' => 0],
            // 'function' => ['role' => 1 | 0, etc.]
    ];
    return $acl;
}
function getAllowed($function, $role)
{
    return getAcl()[$function][$role] ?? FALSE;
}
$html .= '<pre>';
if (isset($_GET['name'])) {
	if (ctype_alpha($_GET['name'])) {
    	// Implement ACL for this function resource
        $userRecord = getUser($_GET['name'], $this->container->get('config'));
    	$role = $userRecord['role'] ?? '';
	    if (getAllowed('getUser',$role)) {
        	foreach ($userRecord as $record) {
        		$html .= " Last Name: {$record[0]} - password: {$record[1]} \n";
        	}
    	} else {
    	    $html .= 'Unauthorized' . PHP_EOL;
    	}
	} else {
	    $html .= 'Invalid Name' . PHP_EOL;
	}
}
$html .= '</pre>';
