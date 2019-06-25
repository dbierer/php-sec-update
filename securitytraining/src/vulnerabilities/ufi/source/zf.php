<?php
/**
 * A File Exists, and inArray Validators
 *
 * Note, this is only checking on existence, and if allowed to include, but does not
 * employ any access control (ACL). An ACL is necessary
 * to determine if the user has:
 * --authorization to include a file
 * --that the specific file inclusion is authorized and exists.
 */
use Zend\Http\PhpEnvironment\Request;
use Zend\ServiceManager\ServiceManager;
use Zend\Validator\File\Exists;
use Zend\Validator\InArray;

$request = new Request();
$container = new ServiceManager(require(__DIR__ . '/../../../../config/config.php'));

if($request->isGet() && $requestedPage = $request->getQuery('page')){
    $existsValidator = new Exists(__DIR__);
    $inArrayValidator = new InArray(['haystack' => $container->get('allowedFiles')]);

    // Check the validation
    if ($existsValidator->isValid($requestedPage) && $inArrayValidator->isValid($requestedPage)) {
        $html = file_get_contents( __DIR__ . '/' . $requestedPage);
    } else {
        $html = 'Page request not available';
    }
}
