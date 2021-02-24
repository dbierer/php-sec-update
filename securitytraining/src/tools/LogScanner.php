<?php
/**
 * Scans Web Server Access Log
 */
namespace src\tools;
use PDO;
class LogScanner
{
    const DEFAULT_TYPE = 'apache';  // otherwise "nginx"
    const APACHE_REGEX = '/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}).*?\[(.+?)]].*?\"(.*?)\" \d+? \d+?$/';
    const DEFAULT_DATE_FMT = 'd/M/Y:H:i:s tzcorrection';
    public $regex = '';
}
