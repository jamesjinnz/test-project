<?php
namespace Catalyst\Entity;

class UserRes extends resCommon
{
    public function insert($data)
    {
        if (!$this->checkTable()){
            echo \cli\line('Error: Please create table '.$this->table. ' before insert the data');
            die;
        }

        $this->sqlBuilder
            ->setTableName($this->table)
            ->setData($data);

        $this->sqlManager->insert($this->sqlBuilder);
    }

    public function createTable()
    {
       $query = "
           CREATE TABLE `".$this->table."` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(50) NOT NULL DEFAULT '',
              `surname` varchar(50) NOT NULL DEFAULT '',
              `email` varchar(254) NOT NULL DEFAULT '',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

        if ($this->checkTable()){
            $this->dbConnect->executeSql('TRUNCATE '.$this->table);
            return false;
        }else{
            $this->dbConnect->executeSql($query);
            return true;
        }
    }

    private function checkTable(){
        $query = "SHOW TABLES LIKE '".$this->table."'";
        $this->sqlBuilder
            ->setQuery($query);
        $result = $this->sqlManager->fetchRow($this->sqlBuilder);
        return ($result) ? true : false;
    }
}