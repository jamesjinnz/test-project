<?php
/**
 * Created by PhpStorm.
 * User: jin
 * Date: 19/01/16
 * Time: 10:08 PM
 */

namespace Catalyst\Library;


use App;
use Catalyst\Entity\User;
use cli\Arguments;
use Setting;

class Console
{
    public $sqlManager;
    public $dbConnect;
    public $app;

    /**
     * Console constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        if($app->dbConn){
            $this->dbConnect =$app->dbConn;
        }
    }


    public function load()
    {
        $this->menu();
    }

    private function menu(){
        $strict = in_array('--strict', $_SERVER['argv']);
        $arguments = new Arguments(compact('strict'));

        $arguments->addFlag(array('help'), 'Show this help screen');
        $arguments->addFlag(array('create_table'),'this will cause the MySQL users table to be built (and no further action will be taken)');
        $arguments->addFlag(array('dry_run'),'this will be used with the --file directive in the instance that we want to run the script but not insert into the DB. All other functions will be executed, but the database won\'t be altered.');
        $arguments->addOption(array('file'), array(
            'description' => '[csv file name] – this is the name of the CSV to be parsed '));
        $arguments->addOption(array('u'), array(
            'description' => 'MySQL username '));
        $arguments->addOption(array('p'), array(
            'description' => 'MySQL password'));
        $arguments->addOption(array('h'), array(
            'description' => 'MySQL host'));
        $arguments->addOption(array('d'), array(
            'description' => 'MySQL database'));

        $arguments->parse();

        if ($arguments['help']) {
            echo $arguments->getHelpScreen();
            echo "\n\n";
            die;
        }else{
            if (!$arguments['u'] && !$arguments['p'] && !$arguments['h']) {
                if(!$this->app->dbConn){
                    echo \cli\line("Warning: Database .env not setup, you also can put Mysql database info in the CLI. Please type --help for more info.");
                    die;
                }
            }

            if(!$this->app->dbConn){
                if (!$arguments['u']){
                    echo \cli\line("Error: Username Missing, -u Mysql Username");
                    die;
                }

                if (!$arguments['p']){
                    echo \cli\line("Error: Password Missing, -u Mysql Password");
                    die;
                }

                if (!$arguments['h']){
                    echo \cli\line("Error: Host Missing, -u Mysql Host");
                    die;
                }
            }

            if ($arguments['u'] || $arguments['p'] || $arguments['h']) {
                if ($arguments['u'] && $arguments['p'] && $arguments['h']) {
                    $dbSetting = new Setting();
                    if(!$this->app->dbConn){
                        if (!$arguments['d']){
                            echo \cli\line("Error: Database Name Missing, -d Mysql Database Name");
                            die;
                        }
                        $database = $arguments['d'];
                    }else{
                        $database = $dbSetting->getDatabase();
                    }
                    $dbConn =$dbSetting->reloadDbConfig($arguments['h'],$arguments['u'],$arguments['p'],$database);
                    $this->dbConnect = $this->app->dbInit($dbConn);
                }else{
                    echo \cli\line("Error: You have to put Mysql host, user and password, please type --help for more detail");
                    die;
                }

            }

        }
        $this->menuProcess($arguments);
    }

    private function menuProcess(Arguments $arguments)
    {
        $csvHandler = new csvHandler();
        $user = new User($this->dbConnect);
        if ($arguments['dry_run']) {
            if ($arguments['file']) {
                $csvHandler->readFile($arguments['file'],$user,true);
            }else{
                echo \cli\line("Error: must used with the --file directive");
            }
        }else{
            if ($arguments['file']) {
                $csvHandler->readFile($arguments['file'],$user,false);
            }

            if ($arguments['create_table']) {
                $result = $user->createTable();
                if ($result){
                    $msg = "User table build now";
                }else{
                    $msg = "User table already existing";
                }
                echo \cli\line($msg);
            }

            if ($arguments['help']) {
                echo $arguments->getHelpScreen();
                echo "\n\n";
            }
        }

    }
}