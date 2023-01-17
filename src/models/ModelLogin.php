<?php

namespace Cmendoza\ApiCdc\models;

use Cmendoza\ApiCdc\lib\Model;
use PDO;
use PDOException;

class ModelLogin extends Model
{
    protected string $clave;
    protected string $mail;
    protected string $status;
    protected string $sql;
    protected array $argc;

    public function __construct()
    {
        parent::__construct();
        $this->connectionDBSQL("DB_NAME2");
    }

    public function get($param)
    {
        try {
            $stm = $this->db->connect()->prepare("SELECT clave, mail, status, celular FROM dbo.registro WHERE clave=? AND mail=?");
            $stm->bindValue(1, $param['clave']);
            $stm->bindValue(2, $param['email']);
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
