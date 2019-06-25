<?php
/* proposed solution */

// create a whitelist of known good values
$flowers = ['pink','orange','purple'];

// try to avoid using $_REQUEST:
if (isset($_POST['type'])) {
    // sanitize
    $type = trim(strip_tags($_POST['type']));
    // validate against whitelist
    $pos  = array_search($type, $flowers);
    $type = ($pos) ? $flowers[$pos] : 'pink';
    // run the query using prepare/execute; also, be specific in columns, try to avoid '*'
    $stmt = $this->getPdo()->prepare('SELECT name,folder FROM flowers WHERE type = ?');
    $stmt->execute([$type]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}

// always provide defaults that are known good values
$name   = $result['name'] ?? 'pink';
$folder = $result['folder'] ?? 'images/';

// sanitize database results
$name = trim(strip_tags($name));
$folder = trim(strip_tags($folder));

// escape output from untrusted sources
$html .= '<img src="' . htmlspecialchars($folder) . htmlspecialchars($name) . '.png" width="50%"/>';
