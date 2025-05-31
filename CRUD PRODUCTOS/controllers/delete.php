<?php
require_once '../config.php';

// Verificar que venga el ID por GET
if (!isset($_GET['id'])) {
    die("ID de producto no especificado.");
}

$id = (int) $_GET['id'];

// Ejecutar la eliminación
$query = "DELETE FROM productos WHERE id = $1";
$result = pg_query_params($dbconn, $query, [$id]);

if ($result) {
    header('Location: ../index.php');
    exit;
} else {
    die("Error al eliminar el producto.");
}
