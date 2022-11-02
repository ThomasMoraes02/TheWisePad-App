<?php 
namespace TheWisePad\Infraestructure;

use PDO;
use Throwable;
use MongoDB\Client;

abstract class ConnectionManager
{
    private static $instance;

    private static function handleConnect($driver): void
    {
        switch ($driver) {
            case 'mysql':
                self::connectMysql();
                break;

            case 'mongodb':
                self::connectMongodb();
                break;
            
            default:
                self::connectSqlite();
                break;
        }
    }

    public static function connect()
    {
        self::handleConnect(DB_DRIVER);
        return self::$instance;
    }

    private static function connectMysql()
    {
        try {
            $instance = new PDO(DB_DRIVER.': host='.DB_HOST.'; dbname='.DB_DATABASE, DB_USER, DB_PASSWORD);
            $instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance = $instance;
        } catch(Throwable $e) {
            echo $e->getMessage();
        }
    }

    private static function connectMongodb()
    {
        try {
            $client = new Client();
            $instance = $client->selectDatabase(DB_DATABASE);
            self::$instance = $instance;
        } catch(Throwable $e) {
            echo $e->getMessage();
        }
    }

    private static function connectSqlite()
    {
        try {
            $dir = __DIR__ . "/../../database/database.sqlite";
            $instance = new PDO("sqlite:" . $dir);
            $instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance = $instance;
        } catch(Throwable $e) {
            echo $e->getMessage();
        }
    }
}