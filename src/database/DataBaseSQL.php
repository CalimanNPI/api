<?php

namespace Cmendoza\ApiCdc\database;

use PDO;
use PDOException;

class DataBaseSQL
{

    private $host;
    private $db;
    private $user;
    private $password;

    public function __construct($_db)
    {
        $this->host = $_ENV['DB_HOST'];
        $this->db = $_ENV[$_db];
        $this->user = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];
    }

    public function connect(): PDO
    {
        try {
            $pdo = new PDO("sqlsrv:Server={$this->host},1433;Database={$this->db}", $this->user, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            exit($exception->getMessage());
        }
    }
}
