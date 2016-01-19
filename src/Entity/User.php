<?php
namespace Catalyst\Entity;

class User extends UserRes
{
    public $table = 'user';
    protected $id;
    protected $name;
    protected $surname;
    protected $email;
}