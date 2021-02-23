<?php
/**
 * Brute Force Detection Class
 */
namespace src\tools;
use PDO;
class BruteForceDetector
{
    protected $db;
    protected $container;
    public function __construct($container){
        $this->container = $container;
    }
    public function detect(){
        // init variables
        $db = $this->container->get('db');
        $pdo = new PDO($db['dsn'], $db['user'], $db['pass']);
        $ip = $forwardIp = $userAgent = $userLan = 'None';
        $today = date("Y-m-j,G");
        $min = date("i");
        $r = substr(date("i"), 0, 1);
        $m = substr(date("i"), 1, 1);
        $minute = 0;
        $store_req = [];

        $config = $this->container->get('bfdetect');
        if ($config['isDisable'] !== 0) return null;

        // to fool most bruce force tools
        header("HTTP/1.1 200 OK");

        if ($m >= 0 && $m <= 5) {
            $m = 5;
            $minute = $r . $m;
        } elseif ($m > 5) {
            $m = 0;
            $r++;
            $r = $r * 10;
            $minute = $r;
        }

        // Remote address of the requester
        if (isset($_SERVER["REMOTE_ADDR"])
            && filter_var($_SERVER["REMOTE_ADDR"], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        // Remote address of the user using the proxy server, if set
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])
            && filter_var($_SERVER["HTTP_X_FORWARDED_FOR"],  FILTER_VALIDATE_IP)) {
            $forwardIp = 'Forward_IP: ' . $_SERVER["HTTP_X_FORWARDED_FOR"];
        }

        // Remote address of the proxy server, if set
        if (isset($_SERVER["HTTP_VIA"])
            && filter_var($_SERVER["HTTP_VIA"], FILTER_VALIDATE_IP)) {
            $forwardIp = $forwardIp . ' VIA: ' . $_SERVER["HTTP_VIA"];
        }

        // The user agent (browser) making the request
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $userAgent = strip_tags($_SERVER["HTTP_USER_AGENT"]);
        }

        // The client accepted language
        if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
            $userLan = strip_tags($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        }

        //Extract , check brute force, deny
        $stmt = $pdo->query("SELECT notify4today, COUNT(today) as hits FROM {$config['table']} WHERE today='$today' AND minute='$minute' GROUP By notify4today, today");
        if ($results = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $store_req['hits'] = (int)$results['hits'];
            $store_req['notify4today'] = (int)$results['notify4today'];
        }

        if (isset($store_req['hits']) && $store_req['hits'] >= $config['maxRequest']) {
            $message = "Date: $today:$min";
            $message .= "IP: $ip,";
            $message .= "Forward Proxy : $forwardIp,";
            $message .= "UserAgent: $userAgent,";
            $message .= "UserLanguage: $userLan";

            $subject = "Possible Brute Force Attack @ $today:$min";

            $pdo->query("UPDATE {$config['table']} SET isnotify='1' WHERE today='$today' AND minute='$minute'");
            $pdo->query("UPDATE {$config['table']} SET notify4today='1' WHERE today='$today' AND minute='$minute'");

            // Assumes a mail server configuration for PHP
            if (isset($store_req['notify4today'])
                && $store_req["notify4today"] === 0
                && $config['emailNotify'] === 1) {
                @mail($config['to'], $subject, $message, $config['headers']);
            }

            if ($config['logAttack'] === 1
                && is_writeable($config['logDir'])) {
                //Must be random
                $logfile = "$today, $min@" . substr(md5(time()), 12);
                error_log("$subject\n$message", 3, "{$config['logDir']}/$logfile");
            }

            if ($store_req["notify4today"] === 0
                && $config['logSys'] === 1
                && isset($_SERVER['REMOTE_ADDR'])
                && isset($_SERVER['HTTP_USER_AGENT'])) {
                $access = date("Y/m/d H:i:s");
                @syslog(LOG_NOTICE, "BruteForce Attack at $access From {$_SERVER['REMOTE_ADDR']} ({$_SERVER['HTTP_USER_AGENT']}) Please ban this IP asap.");
            }

            // Watch out for DOS attacks with a pause like this
            if ($config['antiAttack'] === 1) {
                ini_set("max_execution_time", $config['sleepTime'] * 60 + 2);
                sleep($config['sleepTime'] * 60);
            }
        }

        $stmt = $pdo->query("SELECT notify4today FROM {$config['table']} WHERE today='$today'");
        $store1_req = $stmt->fetch(\PDO::FETCH_ASSOC);
        $fields = ['today','minute','ip','forward_ip','useragent','userlan'];
        $values = [$today,$minute,$ip,$forwardIp,$userAgent,$userLan];
        if (!empty($store1_req) && $store1_req["notify4today"] == 1) {
            $fields[]= 'notify4today';
            $values[] = 1;
        }
        $sql = 'INSERT INTO ' . $config['table']
             . ' (' . implode(',', $fields) . ') '
             . 'VALUES (\'' . implode("','", $values) . '\');';
        $stmt = $pdo->query($sql);
        return $stmt->rowCount();
    }
}
