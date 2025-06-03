<?php

require_once '../config.php';

$errors = [];
$tablaPermitidas = ['productos', 'pedidos'];

//valdiar tabla 
$tabla = $_GET['table'] ?? $_POST['table'] ?? null;
if (!in_array($tabla, $tablaPermitidas)) {
    die("Tabla inválida.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if ($tabla === 'productos') {
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = trim($_POST['precio'] ?? '');

        // Validación de campos
        if ($nombre === '') {
            $errors[] = 'El nombre es obligatorio.';
        }
        if (!is_numeric($precio) || $precio <= 0) {
            $errors[] = 'El precio debe ser un número positivo.';
        }

        // Si no hay errores, insertar en la base de datos
        if (empty($errors)) {
            $query = "INSERT INTO productos (nombre, descripcion, precio) VALUES ($1, $2, $3)";
            $result = pg_query_params($dbconn, $query, [$nombre, $descripcion, $precio]);

            if ($result) {
                header('Location: ../index.php');
                exit;
            } else {
                $errors[] = 'Error al insertar el producto en la base de datos.';
            }
        }
    }

    if ($tabla === 'pedidos') {
        $producto_id = trim($_POST['producto_id'] ?? '');
        $cantidad = trim($_POST['cantidad'] ?? '');


        // Validación de campos
        if ($producto_id === '') {
            $errors[] = 'El nombre es obligatorio.';
        }
        if (!is_numeric($cantidad) || $cantidad <= 0) {
            $errors[] = 'El precio debe ser un número positivo.';
        }

        // Si no hay errores, insertar en la base de datos
        if (empty($errors)) {
            $query = "INSERT INTO pedidos (producto_id, cantidad) VALUES ($1, $2)";
            $result = pg_query_params($dbconn, $query, [$producto_id, $cantidad]);

            if ($result) {
                header('Location: ../index.php');
                exit;
            } else {
                $errors[] = 'Error al insertar el pedido en la base de datos.';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Crear <?= htmlspecialchars($tabla) ?></title>
</head>

<body>
    <link rel="stylesheet" href="../styles.css">

    <h1>Crear <?= htmlspecialchars($tabla) ?></h1>
    <a href="../index.php">Volver al listado</a>

    <?php if ($errors): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="create.php?table=<?= htmlspecialchars($tabla) ?>">

        <?php if ($tabla === 'productos'): ?>
            <label>Nombre:</label><br>
            <input type="text" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"><br><br>

            <label>Descripción:</label><br>
            <textarea name="descripcion"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea><br><br>

            <label>Precio:</label><br>
            <input type="text" name="precio" value="<?= htmlspecialchars($_POST['precio'] ?? '') ?>"><br><br>
        <?php elseif ($tabla === 'pedidos'): ?>
            <label>Producto ID:</label><br>
            <input type="number" name="producto_id" value="<?= htmlspecialchars($_POST['producto_id'] ?? '') ?>"><br><br>

            <label>Cantidad:</label><br>
            <input type="number" name="cantidad" value="<?= htmlspecialchars($_POST['cantidad'] ?? '') ?>"><br><br>
        <?php endif; ?>

        <button type="submit">Crear</button>
    </form>

</body>

</html>