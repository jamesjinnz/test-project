<?php
namespace Catalyst\Entity;


use Simplon\Mysql\Manager\SqlManager;
use Simplon\Mysql\Manager\SqlQueryBuilder;

class resCommon
{
    public $sqlBuilder;
    public $sqlManager;
    public $dbConnect;

    /**
     * resCommon constructor.
     * @param $dbConn
     */
    public function __construct($dbConn)
    {
        $this->sqlManager = new SqlManager($dbConn);
        $this->dbConnect = $dbConn;
        $this->sqlBuilder = new SqlQueryBuilder();
    }
}