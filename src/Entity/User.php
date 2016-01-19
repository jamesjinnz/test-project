<?php
namespace Catalyst\Entity;

use Egulias\EmailValidator\EmailValidator;

class User extends UserRes
{
    public $table = 'user';
    protected $id;
    protected $name;
    protected $surname;
    protected $email;


    public function filterName($name){
        $this->name = ucfirst($name);
        return $this->name;
    }

    public function filterSurname($surname){
        $this->surname = ucfirst($surname);
        return $this->surname;
    }

    public function filterEmail($email){
        $emailResult =  $this->validEmail($email);
        if ($emailResult['status']){
            $this->email = strtolower($email);
            return $this->email;
        }else{
            return $emailResult;
        }
    }

    /**
     * Validate Email Address Format
     * @param $email
     * @return array
     */
    private function validEmail($email){
        $validator = new EmailValidator;

        $result = array(
            'status'=>true,
        );

        if (!$validator->isValid($email)) {
            $result = array(
                'msg'=>$email.' is not a legal format',
                'status'=>false,
            );
        }
        return $result;
    }
}