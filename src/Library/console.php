<?php
/**
 * Created by PhpStorm.
 * User: jin
 * Date: 19/01/16
 * Time: 10:08 PM
 */

namespace Catalyst\Library;


use Catalyst\Entity\User;
use cli\Arguments;
use Simplon\Mysql\Manager\SqlManager;

class Console
{
    public $sqlManager;
    public $dbConnect;

    /**
     * Console constructor.
     * @param $dbConn
     */
    public function __construct($dbConn)
    {
        $this->sqlManager = new SqlManager($dbConn);
        $this->dbConnect = $dbConn;
    }

    public function load()
    {
        $this->menu();
    }

    private function menu(){
        $strict = in_array('--strict', $_SERVER['argv']);
        $arguments = new Arguments(compact('strict'));

        $arguments->addFlag(array('help', 'h'), 'Show this help screen');
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

        $arguments->parse();
        $this->menuProcess($arguments);
    }

    private function menuProcess(Arguments $arguments)
    {
        $csvHandler = new csvHandler();
        if ($arguments['dry_run']) {
            if ($arguments['file']) {
                $csvHandler->readFile($arguments['file'],false);
            }else{
                echo \cli\line("Error: must used with the --file directive");
            }
        }else{
            if ($arguments['file']) {
                $csvHandler->readFile($arguments['file']);
            }

            if ($arguments['create_table']) {
                $user = new User($this->dbConnect);
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