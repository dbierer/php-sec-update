<?php
/**
 * A Zend Framework Example
 */
use Zend\Http\PhpEnvironment\Request;
use Zend\ServiceManager\ServiceManager;
use Zend\Validator\InArray;

$request = new Request();
$container = new ServiceManager(require(__DIR__ . '/../../../../config/config.php'));
if ($request->isPost() && $request->getPost('Upload')) {
    $type = $_FILES['uploaded']['type'];
    $inArrayValidator = new InArray(['haystack' => $container->get('disAllowedFileUploadTypes')]);

    if ($inArrayValidator->isValid($type)) {
        $html .= "File type: <em>'$type'</em> is not allowed";
    }
}