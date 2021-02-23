<?php
/**
 * PHP BruteForce Attack Detector
 */
use src\tools\BruteForceDetector;
use Laminas\ServiceManager\ServiceManager;
require __DIR__ . '/../../../../../vendor/autoload.php';
$config = require(__DIR__ . '/../../../../../config/config.php');
$container = new ServiceManager($config);
$bf = new BruteForceDetector($container);
$error_msg = "<h2>Page Not Found</h2>";
if(!$bf->detect())die($error_msg);
echo "Thank you for visiting";
