<?php 
namespace TheWisePad\Infraestructure;

use PDO;
use PDOException;

class ConnectionPdo
{
    protected $pdo;

    public function getConnection($params = null)
    {
        if(is_null($params)) {
            // Connection Mysql
        }

        $dir = __DIR__ . "/../../database.sqlite";
        try {
            $this->pdo = new PDO("sqlite:" . $dir);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        return $this->pdo;
    }
}