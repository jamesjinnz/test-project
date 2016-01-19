<?php
//Database configuration
require_once(dirname(__DIR__) . '/vendor/autoload.php');

/**
 * Database Setting
 * Class Setting
 */
class Setting {

    protected $host;
    protected $user;
    protected $password;
    protected $database;
    protected $port;

    /**
     * Setting constructor.
     */
    public function __construct()
    {
        $this->preLoad(dirname(__DIR__));
        $this->host = getenv('DB_HOST');
        $this->user = getenv('DB_USER');
        $this->password = getenv('DB_PASSWORD');
        $this->database = getenv('DB_NAME');
        $this->port = getenv('DB_HOST');
    }

    /**
     * @return array
     */
    public function config(){
        $dbConfig = array(
            // required credentials
            'host'       => $this->host,
            'user'       => $this->user,
            'password'   => $this->password,
            'database'   => $this->database,
            // optional
            'fetchMode'  => \PDO::FETCH_ASSOC,
            'charset'    => 'utf8',
            'port'       => $this->port,
            'unixSocket' => null,
        );
        return $dbConfig;
    }

    /**
     * Loading DotEnv for reading .env setting
     * @param $path
     */
    private function preLoad($path){
        try {
            $dotenv = new Dotenv\Dotenv($path);
            $dotenv->load();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            die;
        }
    }
}
