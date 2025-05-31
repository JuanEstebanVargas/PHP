<?php

/**
 * views/read/detail.php
 * Variables disponibles:
 *   - $entity (string): 'users', 'products' u 'orders'
 *   - $row (array|null): datos del registro o null si no existe
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle de <?= ucfirst($entity) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4">Detalle de <?= ucfirst($entity) ?></h1>

        <?php if ($row): ?>
            <dl class="row mb-4">
                <?php foreach ($row as $col => $val): ?>
                    <dt class="col-sm-3"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $col))) ?>:</dt>
                    <dd class="col-sm-9"><?= htmlspecialchars($val) ?></dd>
                <?php endforeach; ?>
            </dl>

        <?php else: ?>
            <div class="alert alert-warning">Registro no encontrado.</div>
        <?php endif; ?>

        <a href="<?= BASE_URL ?>index.php?action=read&entity=<?= $entity ?>" class="btn btn-secondary">
            ← Volver al listado
        </a>
        <a href="<?= BASE_URL ?>" class="btn btn-link">Inicio</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+1mqVI44l9vYh3Q+YfkvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
</body>

</html>