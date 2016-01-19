<?php
use Catalyst\Library\Console;
use Simplon\Mysql\Manager\SqlManager;
use Simplon\Mysql\Mysql;

//Initial bootstrapper for app
require_once(dirname(__DIR__) . '/Config/setting.php');

class App {

    public $sqlManager;
    public $dbConn;

    /**
     * Loading Init function
     */
    public function load(){
        $this->dbConn = $this->dbInit();
        $console = new Console($this->dbConn);
        $console->load();
    }

    /**
     * Database connection
     * @return \Simplon\Mysql\Mysql
     */
    private function dbInit()
    {
        $db = new Setting();
        $dbConfig = $db->config();
        // database standard setup
        $dbConn = new Mysql(
            $dbConfig['host'],
            $dbConfig['user'],
            $dbConfig['password'],
            $dbConfig['database']
        );
        return $dbConn;
    }
}

$app = new App();
$app->load();