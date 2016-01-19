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
    public $debug = false;

    /**
     * Setting constructor.
     */
    public function __construct()
    {
        $result = $this->loadingDbByEnv(dirname(__DIR__));
        if ($result){
            $this->host = getenv('DB_HOST');
            $this->user = getenv('DB_USER');
            $this->password = getenv('DB_PASSWORD');
            $this->database = getenv('DB_NAME');
            $this->port = getenv('DB_HOST');
        }
    }

    public function reloadDbConfig($host,$user,$password,$database,$port = 3389)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
        return $this->config();
    }

    public function getDatabase(){
        return $this->database;
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
     * @return bool
     */
    public function loadingDbByEnv($path){
        try {
            $dotenv = new Dotenv\Dotenv($path);
            $dotenv->load();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
