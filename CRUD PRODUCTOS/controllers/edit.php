<?php
require_once '../config.php';

$errors = [];

// Verificar que venga el ID por GET
if (!isset($_GET['id'])) {
    die("ID de producto no especificado.");
}

$id = (int) $_GET['id'];

// Obtener los datos actuales del producto para mostrar en el formulario
$query = "SELECT * FROM productos WHERE id = $1";
$result = pg_query_params($dbconn, $query, [$id]);

if (!$result || pg_num_rows($result) === 0) {
    die("Producto no encontrado.");
}

$producto = pg_fetch_assoc($result);

// Procesar el formulario al enviar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = trim($_POST['precio'] ?? '');

    // Validaciones
    if ($nombre === '') {
        $errors[] = 'El nombre es obligatorio.';
    }
    if (!is_numeric($precio) || $precio <= 0) {
        $errors[] = 'El precio debe ser un número positivo.';
    }

    if (empty($errors)) {
        $updateQuery = "UPDATE productos SET nombre = $1, descripcion = $2, precio = $3 WHERE id = $4";
        $updateResult = pg_query_params($dbconn, $updateQuery, [$nombre, $descripcion, $precio, $id]);

        if ($updateResult) {
            header('Location: ../index.php');
            exit;
        } else {
            $errors[] = 'Error al actualizar el producto.';
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar Producto</title>
</head>

<body>
    <link rel="stylesheet" href="../styles.css">

    <h1>Editar Producto</h1>
    <a href="../index.php">Volver al listado</a>

    <?php if ($errors): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="editar.php?id=<?= $id ?>">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? $producto['nombre']) ?>"><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"><?= htmlspecialchars($_POST['descripcion'] ?? $producto['descripcion']) ?></textarea><br><br>

        <label>Precio:</label><br>
        <input type="text" name="precio" value="<?= htmlspecialchars($_POST['precio'] ?? $producto['precio']) ?>"><br><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>

</html>