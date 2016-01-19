<?php
/**
 * Created by PhpStorm.
 * User: jamesjin
 * Date: 19/01/16
 * Time: 9:22 PM
 */

namespace Catalyst\Library;


use League\Csv\Reader;

class csvHandler
{
    public function readFile($fileName, $dry=false){
        if (!file_exists($fileName)){
            echo \cli\line("Error: File not existing,Please type file absolute path");
            die;
        }

        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }

        $csv = Reader::createFromPath($fileName);
        $this->writeDateToUser($csv,$dry);
    }

    private function writeDateToUser(Reader $csv, $dry=false){
        $csv->setOffset(1); //because we don't want to insert the
        if (!$dry){

        }else{
            $csv->each(function ($row) {
                $msg = $this->infoDisplay($row);
                echo \cli\line($msg);
                return true;
            });
        }
    }

    private function infoDisplay($row){
        $msg  = '--> ';
        $msg .= ' [Name] '.$row[0];
        $msg .= ' [Surname] '.$row[1];
        $msg .= ' [Email] '.$row[2];
        $msg .= ' loading ...';
        return $msg;
    }
}