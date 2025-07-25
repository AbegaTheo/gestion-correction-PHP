<?php
namespace Config;

use PDO;

class Database {
    private static $pdo = null;

    private const HOST = 'localhost';
    private const DBNAME = 'gestion_correction';
    private const USER = 'root';
    private const PASSWORD = '';

    public static function getConnection() {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=' . self::HOST . ';dbname=' . self::DBNAME . ';charset=utf8',
                    self::USER,
                    self::PASSWORD,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                    ]
                );
            } catch (\PDOException $e) {
                throw new \PDOException('Connexion échouée : ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
