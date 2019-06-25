<?php
/**
 *********************************************************************
 * PLEASE, DON'T TOUCH THIS CODE: This code is deliberately vulnerable
 * Please edit the "with.php" file fixing any vulnerabilities found
 *********************************************************************
 */

if(isset($_GET['page'])){
	require $_GET['page'];//The page we wish to display
}