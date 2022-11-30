<?php

namespace Cmendoza\ApiCdc\models;

use Cmendoza\ApiCdc\database\DataBaseSQL;
use PDO;
use PDOException;

class ModelActivity
{
    protected string $id;
    protected string $actividad;
    protected string $status;
    protected string $niveles;
    protected string $edad;
    protected string $cantidad;
    protected string $prrofesor;
    protected string $horaini;
    protected string $horafin;
    protected string $numero;
    protected string $pmes;
    protected string $pdia;
    protected string $fecha;
    protected string $ubicacion;
    private DataBaseSQL $db;

    public function __construct()
    {
        $this->db = new DataBaseSQL("DB_NAME3");
    }

    public function getAll()
    {
        try {
            $sql = "SELECT actividad, status, numero, ubicacion, niveles, edad, precio, dia, 
                           fecha, dias, horini, horfin, cantidad, profesor, prof_num 
                    FROM dbo.actividades WHERE baja!='B' ORDER BY actividad ASC ";
            $stm = $this->db->connect()->prepare($sql);
            $stm->execute();
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            return $stm->fetchAll();
        } catch (PDOException $e) {
            return ["message" => $e->getMessage()];
        }
    }

    public function getActi($numero)
    {
        try {
            $sql = "SELECT actividad, status, numero, ubicacion, niveles, edad, precio, dia, 
                           fecha, dias, horini, horfin, cantidad, profesor, prof_num, descripActi, clave  
                    FROM dbo.actividades WHERE numero=? AND baja!='B' ";
            $stm = $this->db->connect()->prepare($sql);
            $stm->execute([$numero]);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            return $stm->fetchAll();
        } catch (PDOException $e) {
            return ['message' => $e->getMessage()];
        }
    }

    public function search($search)
    {
        try {
            $like =  "%$search%";
            $sql = "SELECT actividad, status, numero, ubicacion, niveles, edad, precio, dia, 
                           fecha, dias, horini, horfin, cantidad, profesor, prof_num  
                    FROM dbo.actividades WHERE actividad LIKE ? OR ubicacion LIKE ? OR niveles LIKE ? OR edad LIKE ?";
            $stm = $this->db->connect()->prepare($sql);
            $stm->execute([$like, $like, $like, $like]);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            return $stm->fetchAll();
        } catch (PDOException $e) {
            return ['message' => $e->getMessage()];
        }
    }
}
