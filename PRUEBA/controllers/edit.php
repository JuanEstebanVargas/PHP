<?php
require_once '../config.php';

$errors = [];
$tablaPermitidas = ['productos', 'pedidos'];

// Validar parámetros GET
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$tabla = $_GET['table'] ?? null;

if ($id <= 0 || !in_array($tabla, $tablaPermitidas)) {
    die("Parámetros inválidos.");
}

// Inicializar variables para el formulario
$nombre = $descripcion = $precio = "";
$producto_id = $cantidad = "";

// Si se envió el formulario POST, actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($tabla === 'productos') {
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = trim($_POST['precio'] ?? '');

        // Validar
        if ($nombre === '') $errors[] = 'El nombre es obligatorio.';
        if (!is_numeric($precio) || $precio <= 0) $errors[] = 'El precio debe ser un número positivo.';

        if (empty($errors)) {
            $query = "UPDATE productos SET nombre = $1, descripcion = $2, precio = $3 WHERE id = $4";
            $result = pg_query_params($dbconn, $query, [$nombre, $descripcion, $precio, $id]);

            if ($result) {
                header('Location: ../index.php');
                exit;
            } else {
                $errors[] = 'Error al actualizar producto.';
            }
        }
    }

    if ($tabla === 'pedidos') {
        $producto_id = trim($_POST['producto_id'] ?? '');
        $cantidad = trim($_POST['cantidad'] ?? '');

        // Validar
        if (!is_numeric($producto_id) || $producto_id <= 0) $errors[] = 'Producto inválido.';
        if (!is_numeric($cantidad) || $cantidad <= 0) $errors[] = 'Cantidad debe ser número positivo.';

        if (empty($errors)) {
            $query = "UPDATE pedidos SET producto_id = $1, cantidad = $2 WHERE id = $3";
            $result = pg_query_params($dbconn, $query, [(int)$producto_id, (int)$cantidad, $id]);

            if ($result) {
                header('Location: ../index.php');
                exit;
            } else {
                $errors[] = 'Error al actualizar pedido.';
            }
        }
    }
} else {
    // Si no es POST, cargar datos actuales para mostrar en formulario
    if ($tabla === 'productos') {
        $query = "SELECT nombre, descripcion, precio FROM productos WHERE id = $1";
        $result = pg_query_params($dbconn, $query, [$id]);
        if ($row = pg_fetch_assoc($result)) {
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
        } else {
            die("Producto no encontrado.");
        }
    }

    if ($tabla === 'pedidos') {
        $query = "SELECT producto_id, cantidad FROM pedidos WHERE id = $1";
        $result = pg_query_params($dbconn, $query, [$id]);
        if ($row = pg_fetch_assoc($result)) {
            $producto_id = $row['producto_id'];
            $cantidad = $row['cantidad'];
        } else {
            die("Pedido no encontrado.");
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar <?= htmlspecialchars($tabla) ?></title>
</head>

<body>
    <link rel="stylesheet" href="../styles.css">

    <h1>Editar <?= htmlspecialchars($tabla) ?></h1>
    <a href="../index.php">Volver al listado</a>

    <?php if ($errors): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="edit.php?id=<?= $id ?>&table=<?= htmlspecialchars($tabla) ?>">

        <?php if ($tabla === 'productos'): ?>
            <label>Nombre:</label><br>
            <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>"><br><br>

            <label>Descripción:</label><br>
            <textarea name="descripcion"><?= htmlspecialchars($descripcion) ?></textarea><br><br>

            <label>Precio:</label><br>
            <input type="text" name="precio" value="<?= htmlspecialchars($precio) ?>"><br><br>

        <?php elseif ($tabla === 'pedidos'): ?>
            <label>Producto ID:</label><br>
            <input type="number" name="producto_id" value="<?= htmlspecialchars($producto_id) ?>"><br><br>

            <label>Cantidad:</label><br>
            <input type="number" name="cantidad" value="<?= htmlspecialchars($cantidad) ?>"><br><br>
        <?php endif; ?>

        <button type="submit">Actualizar</button>
    </form>

</body>

</html>