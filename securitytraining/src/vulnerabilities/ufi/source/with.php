<?php
/* This is the code file you need to modify */

if(isset($_GET['page'])){
	require __DIR__ . '/' . $_GET['page'];  //The page we wish to display
}
