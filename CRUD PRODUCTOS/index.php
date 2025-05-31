<?php
require 'config.php';

// Ejecutar consulta
$query = "SELECT * FROM productos ORDER BY creado_en DESC";
$result = pg_query($dbconn, $query);

if (!$result) {
    die("Error al ejecutar la consulta.");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Listado de Productos</title>
</head>

<body>
    <h1>Listado de Productos</h1>
    <link rel="stylesheet" href="styles.css">
    <a href="/controllers/create.php">Crear nuevo producto</a>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $hayProductos = false;
            while ($prod = pg_fetch_assoc($result)) {
                $hayProductos = true;
            ?>
                <tr>
                    <td><?= htmlspecialchars($prod['id']) ?></td>
                    <td><?= htmlspecialchars($prod['nombre']) ?></td>
                    <td><?= htmlspecialchars($prod['descripcion']) ?></td>
                    <td>$<?= number_format($prod['precio'], 2) ?></td>
                    <td>
                        <a href="/controllers/edit.php?id=<?= $prod['id'] ?>">Editar</a> |
                        <a href="/controllers/delete.php?id=<?= $prod['id'] ?>" onclick="return confirm('¿Eliminar producto?')">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>

            <?php if (!$hayProductos): ?>
                <tr>
                    <td colspan="5">No hay productos</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>