<?php
// Parámetros de conexión a PostgreSQL
$host = 'localhost';   // Dirección del servidor PostgreSQL
$db   = 'PRUEBA1';      // El nombre de tu base de datos
$user = 'postgres';    // El usuario por defecto de PostgreSQL
$pass = '1234'; // La contraseña de tu base de datos
$port = '5432';        // Puerto de PostgreSQL (por defecto es 5432)

$connection_string = "host=$host port=$port dbname=$db user=$user password=$pass";

// Conectar a PostgreSQL
$dbconn = pg_connect($connection_string);

if (!$dbconn) {
    die("Error de conexión a PostgreSQL.");
}
