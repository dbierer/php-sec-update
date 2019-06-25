<?php
/* This is the code file you need to modify */

$target_path = __DIR__ . "/hackable/uploads/";
$this->view->setTargetPath($target_path);
if (isset($_POST['Upload'])) {
    $file = basename($_FILES['uploaded']['name']);
    $target_path = $target_path . $file;

    if (!move_uploaded_file($_FILES['uploaded']['tmp_name'], $target_path)) {
        $html .= '<pre>';
        $html .= 'Your file was not uploaded.';
        $html .= '</pre>';
    } else {
        $file = rawurlencode($file);
        $link = wordwrap($this->url . "/src/vulnerabilities/ifu/source/hackable/uploads/$file", 74, PHP_EOL, true);
        $html .= '<pre>File succesfully uploaded! Click to have access:<br>';
        $html .= '<a href="' . $link . '" target="_blank">' . $link . '</a>';
        $html .= '</pre>';
    }
}
