<?php
/**
 * Created by PhpStorm.
 * User: jin
 * Date: 19/01/16
 * Time: 10:08 PM
 */

namespace Catalyst\Library;


use cli\Arguments;

class Console
{

    /**
     * Console constructor.
     */
    public function load()
    {
        $this->menu();
    }

    private function menu(){
        $strict = in_array('--strict', $_SERVER['argv']);
        $arguments = new Arguments(compact('strict'));

        $arguments->addFlag(array('help', 'h'), 'Show this help screen');
        $arguments->addOption(array('file'), array(
            'description' => '[csv file name] – this is the name of the CSV to be parsed '));
        $arguments->addOption(array('create_table'), array(
            'description' => 'this will cause the MySQL users table to be built (and no further action will be taken)'));
        $arguments->addOption(array('dry_run'), array(
            'description' => 'this will be used with the --file directive in the instance that we want to run the script but not insert into the DB. All other functions will be executed, but the database won\'t be altered.'));
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
        if ($arguments['help']) {
            echo $arguments->getHelpScreen();
            echo "\n\n";
        }
    }
}