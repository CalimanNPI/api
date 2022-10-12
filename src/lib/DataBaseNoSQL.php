<?php


namespace Cmendoza\ApiCdc\lib;

use Exception;
use MongoDB\Client as Mongo;

class DataBaseNoSQL
{

    private $mdb_host;
    private $mdb_user;
    private $mdb_pass;
    private $mdb_atlas_cluster_srv;

    function __construct()
    {
        $this->mdb_host = $_ENV['MDB_HOST'];
    }

    public function connect()
    {
        try {
            $mdb = new Mongo("mongodb://{$this->mdb_host}");
            return $mdb;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
