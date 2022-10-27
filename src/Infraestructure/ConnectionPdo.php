<?php 
namespace TheWisePad\Infraestructure;

use PDO;
use PDOException;

class ConnectionPdo
{
    protected $pdo;

    public function getConnection()
    {
        try {
            $this->pdo = $this->generateInstancePdo();
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        return $this->pdo;
    }

    public function generateInstancePdo(): PDO
    {
        if(DB_DRIVER == "mysql") {
            return new PDO(DB_DRIVER.': host='.DB_HOST.'; dbname='.DB_DATABASE, DB_USER, DB_PASSWORD);
        }

        $dir = __DIR__ . "/../../database/database.sqlite";
        return new PDO("sqlite:" . $dir);
    }
}