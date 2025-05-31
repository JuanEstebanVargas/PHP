<?php

/**
 * views/delete/confirm.php
 * Variables disponibles:
 *   - $entity (string): 'users', 'products' u 'orders'
 *   - $row (array|null): datos del registro
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eliminar <?= ucfirst($entity) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4 text-danger">Eliminar <?= ucfirst($entity) ?></h1>

        <?php if ($row): ?>
            <div class="alert alert-danger">
                <p>¿Estás seguro de que deseas eliminar este registro?</p>
                <ul class="list-group mb-4">
                    <?php foreach ($row as $col => $val): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $col))) ?>:</strong>
                            <span><?= htmlspecialchars($val) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <form action="<?= BASE_URL ?>index.php?action=delete" method="post" class="d-inline">
                    <input type="hidden" name="entity" value="<?= htmlspecialchars($entity) ?>">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                </form>
                <a href="<?= BASE_URL ?>index.php?action=read&entity=<?= $entity ?>" class="btn btn-secondary ms-2">
                    No, volver atrás
                </a>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Registro no encontrado.</div>
            <a href="<?= BASE_URL ?>index.php?action=read&entity=<?= $entity ?>" class="btn btn-secondary">
                Volver al listado
            </a>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+1mqVI44l9vYh3Q+YfkvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
</body>

</html>