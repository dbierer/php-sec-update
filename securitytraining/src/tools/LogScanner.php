<?php
/**
 * Scans Web Server Access Log
 * Uses SQLite3
 */
namespace src\tools;
use PDO;
class LogScanner
{
    const ERROR_DATABASE = 'ERROR: database';
    const DEFAULT_TYPE = 'apache';  // otherwise "nginx"
    // see: http://httpd.apache.org/docs/current/mod/mod_log_config.html#formats
    const APACHE_LOG_FMT = '%h %l %u %t \"%r\" %>s %b';
    const DB_FIELDS = [
        'id'          => 'INT PRIMARY KEY',
        'ip'          => 'TEXT',
        'misc1'       => 'TEXT',
        'misc2'       => 'TEXT',
        'entry_date'  => 'TEXT',
        'http_method' => 'TEXT',
        'url_path'    => 'TEXT',
        'http_ver'    => 'TEXT',
        'http_status' => 'INT'
    ];
    public $regex = '';
    public $pdo   = NULL;
    /**
     * Initializes the database connection
     *
     * @param string $fn : path to database file
     */
    public function init(string $fn)
    {
        $this->pdo = new PDO('pdo_mysql:dbname=' . $fn);
    }
    /**
     * Builds PCRE regex from log file format
     *
     * @param string $fmt : log file format
     */
    public function buildRegexFromLogFmt($fmt)
    {
    }
    /**
     * @param string $fn : path to SQLite3 database
     * @param string $message : error messages returned by reference + logged
     * @return int $result : number of rows affected
     */
    public function createDatabase(string $fn, string &$message = '') : int
    {
        $result = 0;
        try {
            $this->init($fn);
            $create = 'CREATE TABLE IF NOT EXISTS ' . TABLE . ' (';
            foreach ($fields as $name => $type)
                $create .= "\n    $name $type,";
            $create = substr($create, 0, -1);
            $create .= ');';
            $result = $this->pdo->exec($create);
        } catch (Throwable $t) {
            error_log(get_class($t) . ':' . $t->getMessage());
            $message = self::ERROR_DATABASE;
        }
        return $result;
    }
}
