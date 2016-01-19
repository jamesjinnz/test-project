<?php
namespace Catalyst\Entity;


use Simplon\Mysql\Manager\SqlManager;
use Simplon\Mysql\Manager\SqlQueryBuilder;

class resCommon
{
    public $sqlBuilder;
    public $sqlManager;

    /**
     * resCommon constructor.
     * @param SqlManager $sqlManager
     */
    public function __construct(SqlManager $sqlManager)
    {
        $this->sqlManager = $sqlManager;
        $this->sqlBuilder = new SqlQueryBuilder();
    }
}