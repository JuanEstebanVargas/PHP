<?php
require 'config.php';

// consulta en pedidos 
$query = "SELECT * FROM productos ORDER BY fecha_creacion DESC";
$result = pg_query($dbconn, $query);

// consulta en pedidos 
$query2 = "SELECT * FROM pedidos ORDER BY fecha_pedido DESC";
$result2 = pg_query($dbconn, $query2);

if (!$result) {
    die("Error al ejecutar la consulta.");
}

if (!$result2) {
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
    <a href="/controllers/create.php?table=productos">Crear nuevo producto</a>
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
                    <td><?= ($prod['id']) ?></td>
                    <td><?= htmlspecialchars($prod['nombre']) ?></td>
                    <td><?= htmlspecialchars($prod['descripcion']) ?></td>
                    <td>$<?= number_format($prod['precio'], 2) ?></td>
                    <td>
                        <a href="/controllers/edit.php?id=<?= $prod['id'] ?>&table=productos">Editar</a> |
                        <a href="/controllers/delete.php?id=<?= $prod['id'] ?>&table=productos" onclick="return confirm('¿Eliminar pedido?')">Eliminar</a>
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



    <a href="/controllers/create.php?table=pedidos">Crear nuevo pedido</a>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto id</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $hayPedidos = false;
            while ($prod = pg_fetch_assoc($result2)) {
                $hayPedidos = true;
            ?>
                <tr>
                    <td><?= number_format($prod['id']) ?></td>
                    <td><?= number_format($prod['producto_id']) ?></td>
                    <td><?= number_format($prod['cantidad']) ?></td>
                    <td>$<?= htmlspecialchars($prod['fecha_pedido']) ?></td>
                    <td>
                        <a href="/controllers/edit.php?id=<?= $prod['id'] ?>&table=pedidos">Editar</a> |
                        <a href="/controllers/delete.php?id=<?= $prod['id'] ?>&table=pedidos" onclick="return confirm('¿Eliminar pedido?')">Eliminar</a>
                    </td>

                </tr>
            <?php } ?>

            <?php if (!$hayPedidos): ?>
                <tr>
                    <td colspan="5">No hay pedidos</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>