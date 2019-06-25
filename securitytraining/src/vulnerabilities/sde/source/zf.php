<?php
/**
 * A Zend Framework Example
 */

use src\domain\UserDomainService;
use src\entity\UserEntity;
use Zend\Http\PhpEnvironment\Request;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;

//filter chain setup for the username
$username = new Input('username');
$username->getFilterChain()
    ->attachByName('htmlentities')
    ->attachByName('alnum')
    ->attachByName('stringtrim');
$username->getValidatorChain()
    ->attachByName('alnum')
    ->attachByName('notEmpty');

//filter chain setup for the password
$password = new Input('password');
$password->getFilterChain()
    ->attachByName('htmlentities')
    ->attachByName('alnum')
    ->attachByName('stringtrim');
$password->getValidatorChain()
    ->attachByName('alnum')
    ->attachByName('notEmpty');

$inputfilter = new InputFilter();
$inputfilter
    ->add($username)
    ->add($password);

$request = new Request();

if ($request->isPost()) {
    //Filter the data
    $inputfilter->setData($request->getPost());

    if($inputfilter->isValid()){
        //Only work with filtered data
        $data = $inputfilter->getValues();
        $user = new UserEntity($data['username'], $data['password']);
        $service = new UserDomainService();

        $html = '';
        if ($service->register($user)) {
            $html .= "<div class=\"vulnerable_code_area\"><h1>Thank you for signing up for our cool new service!</h1></div>";
        }
    } else {
        $html .= "<div class=\"vulnerable_code_area\"><h1>Uh...sorry, something's wrong or missing in your input!</h1></div>";
    }
}