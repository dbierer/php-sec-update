<?php

if(isset($_GET['page'])) {
	$includeFile = $_GET['page']; //The page we wish to display
	$allowed = ['include.php'];
    // locates the key for matching array element or FALSE
    $key = array_search($includeFile, $allowed);
	if ($key !== FALSE) {
        // NOTE: we *never* directly use user supplied  input
		require $allowed[$key];
	} else {
		$html = "<pre>Invalid file specification</pre>";
	}
}
