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
    private $debug = false;

    /**
     * csvHandler constructor.
     * @param bool $debug
     */
    public function __construct($debug)
    {
        $this->debug = $debug;
    }


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
        $csv->setOffset(1); //because we don't want to insert the header

        $csv->each(function ($row) use ($user,$dry) {
            if ($row){
                $result = $this->infoDisplay($row,$user);
                if ($result['status']){
                    if (!$dry){
                        $data = array(
                            'name' => $user->getName(),
                            'surname'  => $user->getSurname(),
                            'email'  => $user->getEmail(),
                        );
                        $user->insert($data);
                    }
                }
                if (!empty($result['msg'])){
                    echo \cli\line($result['msg']);
                }
            }
            return true;
        });
    }

    private function infoDisplay($row,User $user){
        $emailResult = $user->filterEmail($row[2]);
        if (!isset($emailResult['status'])){
            $name = $user->filterName($row[0]);
            $surname = $user->filterSurname($row[1]);
            $msg = '';
            if ($this->debug){
                $msg  = '--> ';
                $msg .= ' [Name] '.$name;
                $msg .= ' [Surname] '.$surname;
                $msg .= ' [Email] '.$emailResult;
                $msg .= ' ...';
            }
            $result = array(
                'status'=>true,
                'msg'=>$msg,
            );
        }else{
            $msg = 'Error: '.$emailResult['msg'];
            $result = array(
                'msg'=>$msg,
                'status'=>false,
            );
        }
        return $result;

    }
}