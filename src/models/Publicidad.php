<?php

namespace Cmendoza\ApiCdc\models;

use Cmendoza\ApiCdc\interfaces\iTemplate as iTemplate;
use Cmendoza\ApiCdc\lib\DataBaseSQL;
use PDO;
use PDOException;

class Publicidad
{
    protected string $id;
    protected string $title;
    protected string $description;
    protected string $uriImg;
    protected string $dateExpiration;
    private DataBaseSQL $db;

    public function __construct()
    {
        $this->db = new DataBaseSQL();
    }

    public function exist(...$params)
    {
    }

    public function get($param)
    {
        try {
            $stm = $this->db->connect()->prepare("SELECT * FROM dbo.publicidad WHERE id=:id");
            $stm->bindValue(':id', $param);
            $stm->execute();
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $respuesta = $stm->fetchAll();
            return $respuesta;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getById($param)
    {
        try {
            $stm = $this->db->connect()->prepare("SELECT * FROM dbo.alto_ren WHERE clave=:id");
            $stm->bindValue(':id', $param);
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
            $stm = $this->db->connect()->prepare("SELECT * FROM dbo.alto_ren");
            $stm->execute();
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $respuesta = $stm->fetchAll();
            return $respuesta;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function save($fields)
    {
        try {
            $stm = $this->db->connect()->prepare("INSERT dbo.publicidad INTO 
            (name, title, description, uriImg, dateExpiration)
             VALUES (:name, :title, :description, :uriImg, :dateExpiration)");
            $this->db->bindAllValues($stm, $fields);
            $stm->execute();
            $id = $this->db->connect()->lastInsertId();
            return $id;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function update($fields, $param)
    {
        try {
            $values = getParams($fields);
            $sql = "
            UPDATE dbo.publicidad
            SET $values
            WHERE id='$param'
             ";
            $stm = $this->db->connect()->prepare($sql);
            $this->db->bindAllValues($stm, $fields);
            $stm->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($param)
    {
        try {
            $stm = $this->db->connect()->prepare('DELETE FROM dbo.publicidad WHERE id=:id');
            $stm->execute(['id' => $param]);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
