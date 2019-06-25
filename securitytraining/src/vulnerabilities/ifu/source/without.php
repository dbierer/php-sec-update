<?php
/**
 *********************************************************************
 * PLEASE, DON'T TOUCH THIS CODE: This code is deliberately vulnerable
 * Please edit the "with.php" file fixing any vulnerabilities found
 *********************************************************************
 */

if (isset($_POST['Upload'])) {
    $target_path = __DIR__ . "/hackable/uploads/";
    $target_path = $target_path . basename($_FILES['uploaded']['name']);

    if (!move_uploaded_file($_FILES['uploaded']['tmp_name'], $target_path)) {
        $html .= '<pre>';
        $html .= 'Your file was not uploaded.';
        $html .= '</pre>';
    } else {
        $html .= '<pre>succesfully uploaded!<br>Click on:<br>';
        $html .= "<a href='http://securitytraining/vulnerabilities/ifu/source/hackable/uploads/{$_FILES['uploaded']['name']}' target='_blank'>http://securitytraining/vulnerabilities/ifu/source/hackable/uploads/{$_FILES['uploaded']['name']}</a>";
        $html .= '</pre>';
    }
}
