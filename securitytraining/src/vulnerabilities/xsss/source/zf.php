<?php
/**
 * A Zend Framework Example
 */

use Zend\Escaper\Escaper;
use Zend\Http\PhpEnvironment\Request;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;

//Setup the input class with filters and validators
$fmtxMessage = new Input("mtxMessage");
$fmtxMessage->getFilterChain()
	->attachByName("HtmlEntities")
	->attachByName("StripTags")
	->attachByName("StringTrim");
$fmtxMessage->getValidatorChain()
	->attachByName('notEmpty');

//Setup the input class with filters and validators
$firstname 	 = new Input("txtName");
$firstname->getFilterChain()
	->attachByName("HtmlEntities")
	->attachByName("StripTags")
	->attachByName("StringTrim");
$firstname->getValidatorChain()
	->attachByName('notEmpty')
	->attachByName('alpha');

$filter= new InputFilter();
$filter->add($fmtxMessage,"mtxMessage")->add($firstname,"txtName");

$request = new Request();
$escaper = new Escaper('utf-8');
if ($request->isPost()){
	
	$filter->setData($request->getPost());
	if($filter->isValid()){
		$values = $filter->getValues();
		$results = null;
        $sql = "INSERT INTO guestbook (comment, name) VALUES ('{$values['mtxMessage']}', '{$values['txtName']}')";
        try{
            $this->adapter->query($sql, $this->adapter::QUERY_MODE_EXECUTE);
            $sql = "SELECT * FROM guestbook";
            $results = $this->adapter->query($sql, $this->adapter::QUERY_MODE_EXECUTE);
		} catch (Throwable $e){
		    echo $e->getMessage();
		}

        if($results){
            $html .= '<h1>Messages</h1>';
            $html .= '<ul>';
            foreach($results as $result){
                $html .= '<li>Name: ' . $escaper->escapeHtml($result->name) . ' Comment: ' . $escaper->escapeHtml($result->comment) . '</li>';
            }
            $html .= '</ul>';
        }
	}
}
