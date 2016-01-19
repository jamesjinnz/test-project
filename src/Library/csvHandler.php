<?php
/**
 * Created by PhpStorm.
 * User: jamesjin
 * Date: 19/01/16
 * Time: 9:22 PM
 */

namespace Catalyst\Library;


use Catalyst\Entity\User;
use League\Csv\Reader;

class csvHandler
{
    public function readFile($fileName, User $user,$dry=false){
        if (!file_exists($fileName)){
            echo \cli\line("Error: File not existing,Please type file absolute path");
            die;
        }

        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }

        $csv = Reader::createFromPath($fileName);
        $this->writeDateToUser($csv,$user,$dry);
    }

    private function writeDateToUser(Reader $csv, User $user, $dry=false){
        $csv->setOffset(1); //because we don't want to insert the
        if (!$dry){

        }else{
            $csv->each(function ($row) use ($user) {
                $msg = $this->infoDisplay($row,$user);
                echo \cli\line($msg);
                return true;
            });
        }
    }

    private function infoDisplay($row,User $user){
        $emailResult = $user->filterEmail($row[2]);
        $msg  = '--> ';
        if (!isset($emailResult['status'])){
            $msg .= ' [Name] '.$user->filterName($row[0]);
            $msg .= ' [Surname] '.$user->filterSurname($row[1]);
            $msg .= ' [Email] '.$emailResult;
            $msg .= ' ...';
        }else{
            $msg .= ' '.$emailResult['msg'];
        }
        return $msg;

    }
}