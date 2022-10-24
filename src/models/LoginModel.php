<?php

namespace Cmendoza\ApiCdc\models;

use Cmendoza\ApiCdc\database\DataBaseSQL;
use PDO;
use PDOException;

class LoginModel
{
    protected string $clave;
    protected string $mail;
    protected string $status;
    private DataBaseSQL $db;

    protected string $sql;
    protected array $argc;

    public function __construct()
    {
        $this->db = new DataBaseSQL("DB_NAME2");
    }

    public function get($param)
    {
        try {
            $stm = $this->db->connect()->prepare("SELECT TOP(1) * FROM dbo.registro WHERE clave=? AND mail=?");
            $stm->bindValue(1, $param['clave']);
            $stm->bindValue(2, $param['mail']);
            $stm->execute();
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $respuesta = $stm->fetchAll();
            return $respuesta;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getAll()
    {
        try {
            $stm = $this->db->connect()->prepare("SELECT TOP(10) * FROM dbo.registro");
            $stm->execute();
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $respuesta = $stm->fetchAll();
            return $respuesta;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
