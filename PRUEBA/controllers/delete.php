<?php
require_once '../config.php';

// Validar que venga el ID por GET
if (!isset($_GET['id'])) {
    die("ID no especificado.");
}

// Validar que venga la tabla por GET y sea válida
$allowedTables = ['productos', 'pedidos'];
if (!isset($_GET['table']) || !in_array($_GET['table'], $allowedTables)) {
    die("Tabla inválida.");
}

$id = (int) $_GET['id'];
$table = $_GET['table'];

// Construir la consulta de forma segura usando whitelist para tabla
$query = "DELETE FROM $table WHERE id = $1";

// Ejecutar la eliminación con parámetro seguro para el ID
$result = pg_query_params($dbconn, $query, [$id]);

if ($result) {
    header('Location: ../index.php');
    exit;
} else {
    die("Error al eliminar.");
}
