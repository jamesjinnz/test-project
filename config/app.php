<?php
use Catalyst\Library\Console;
use Simplon\Mysql\Mysql;

//Initial bootstrapper for app
require_once(dirname(__DIR__) . '/Config/setting.php');

class App {

    public $sqlManager;
    public $dbConn;
    public $console;

    /**
     * Loading Init function
     */
    public function load(){
        $setting = new Setting();
        if (!$setting->debug){
            error_reporting(0);
        }
        if ($setting->loadingDbByEnv(dirname(__DIR__))){
            $this->dbConn = $this->dbInit($setting->config());
        }
        $this->console = new Console($this,$setting->debug);
    }

    /**
     * @param $dbConfig
     * @return Mysql
     */
    public function dbInit($dbConfig)
    {
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