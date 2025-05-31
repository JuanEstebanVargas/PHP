<?php

require_once '../config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $errors[] = 'Error al insertar en la base de datos.';
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Crear Producto</title>
</head>

<body>
    <link rel="stylesheet" href="../styles.css">

    <h1>Crear Producto</h1>
    <a href="../index.php">Volver al listado</a>

    <?php if ($errors): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="create.php">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea><br><br>

        <label>Precio:</label><br>
        <input type="text" name="precio" value="<?= htmlspecialchars($_POST['precio'] ?? '') ?>"><br><br>

        <button type="submit">Crear</button>
    </form>
</body>

</html>