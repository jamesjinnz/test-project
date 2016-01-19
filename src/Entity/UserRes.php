<?php
namespace Catalyst\Entity;

class UserRes extends resCommon
{
    public function insert($data)
    {
        $this->sqlBuilder
            ->setTableName($this->table)
            ->setData($data);

        $this->sqlManager->insert($this->sqlBuilder);
    }
}