<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    private $host = 'localhost';
    private $db_name = 'controlcoins';
    private $username = 'vitor';
    private $password = 'senha123';
    private $port = '3306';

    public function connect(): PDO
    {
        try {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $this->host,
                $this->port,
                $this->db_name
            );

            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;

        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
}

$conn = new Database();
$conn->connect();