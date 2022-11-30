<?php

namespace Cmendoza\ApiCdc\models;

use Cmendoza\ApiCdc\database\DataBaseSQL;
use PDO;
use PDOException;

class UserModel
{
    public string $tipo;
    public string $clave;
    private DataBaseSQL $db;

    function  __construct()
    {
        $this->db = new DataBaseSQL('DB_NAME');
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function setClave($clave)
    {
        $this->clave = $clave;
    }

    public function getUser()
    {
        try {
            $sql = '';
            if ($this->tipo == "U") {
                $sql = 'SELECT * FROM dbo.usuario WHERE clave=?';
            } else if ($this->tipo == "X") {
                $sql = 'SELECT * FROM dbo.usuariointer WHERE clave=?';
            } else if ($this->tipo == "A") {
                $sql = 'SELECT * FROM dbo.alto_ren WHERE clave=?';
            } else {
                return 'Tipo de usuario incorrecto';
            }

            $stm = $this->db->connect()->prepare($sql);
            $stm->execute([$this->clave]);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stm->fetchAll();
            return empty($result) ?  "No se encontro ningún registro" : $result;
        } catch (PDOException $e) {
            return  $e->getMessage();
        }
    }

    public function getUserNom()
    {
        try {
            $sql = 'SELECT nombre, clave, tel_cel, mail FROM dbo.usuario WHERE clave=?';
            $stm = $this->db->connect()->prepare($sql);
            $stm->execute([$this->clave]);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stm->fetchAll();
            return empty($result) ?  "No se encontro ningún registro" : $result;
        } catch (PDOException $e) {
            return  $e->getMessage();
        }
    }
}
