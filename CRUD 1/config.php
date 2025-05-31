<?php

define('DB_HOST',   'localhost');
define('DB_PORT',   '5432');
define('DB_NAME',   'crud_php');
define('DB_USER',   'postgres');
define('DB_PASS',   '1234');

define('BASE_URL',  '/mi_proyecto/public/');

function getDatabaseConnection()
{
    try {
        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            DB_HOST,
            DB_PORT,
            DB_NAME
        );
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión a la BD: " . $e->getMessage());
    }
}
