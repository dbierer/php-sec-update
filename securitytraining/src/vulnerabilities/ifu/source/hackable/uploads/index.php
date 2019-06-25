<?php
$output = '';
if (isset($_GET['name'])) {
	$output = "Hello {$_GET['name']} and welcome to our same day delivery service";
} else {
	$output .= "Hello ";
}
$output .= 'and welcome to our same day delivery service';
echo $output;