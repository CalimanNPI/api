<?php


namespace Cmendoza\ApiCdc\lib;

use Cmendoza\ApiCdc\database\DataBaseSQL;
use Cmendoza\ApiCdc\database\DataBaseNoSQL;

class Model
{
    protected  DataBaseSQL $db;
    protected  DataBaseNoSQL $dbm;
    protected $collection;

    public function __construct()
    {
    }

    protected  function connectionDBSQL($db)
    {
        $this->db = new DataBaseSQL($db);
    }

    protected  function connectionDBMongo($cool)
    {
        $this->dbm = new DataBaseNoSQL();
        $this->collection =  $this->dbm->connect()->notificacion->$cool;
    }
}
