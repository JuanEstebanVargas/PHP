<?php

/**
 * views/read/list.php
 * Variables disponibles:
 *   - $entity (string): 'users', 'products' u 'orders'
 *   - $rows (array): registros traídos desde el modelo
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de <?= ucfirst($entity) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+1mqVI44l9vYh3Q+YfkvH+8abtTE1Pi6jizo"
        crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Listado de <?= ucfirst($entity) ?></h1>
            <a href="<?= BASE_URL ?>index.php?action=create&entity=<?= $entity ?>" class="btn btn-success">
                + Crear <?= rtrim(ucfirst($entity), 's') ?>
            </a>
        </div>

        <?php if (empty($rows)): ?>
            <div class="alert alert-info">No hay registros en <?= ucfirst($entity) ?>.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <?php
                            // Encabezados a partir de la primera fila
                            foreach (array_keys($rows[0]) as $col) {
                                echo "<th>" . htmlspecialchars($col) . "</th>";
                            }
                            ?>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <?php foreach ($row as $field): ?>
                                    <td><?= htmlspecialchars($field) ?></td>
                                <?php endforeach; ?>
                                <td class="text-center">
                                    <a href="<?= BASE_URL ?>index.php?action=readDetail&entity=<?= $entity ?>&id=<?= $row['id'] ?>"
                                        class="btn btn-sm btn-primary me-1">Ver</a>
                                    <a href="<?= BASE_URL ?>index.php?action=updateForm&entity=<?= $entity ?>&id=<?= $row['id'] ?>"
                                        class="btn btn-sm btn-warning me-1">Editar</a>
                                    <a href="<?= BASE_URL ?>index.php?action=deleteConfirm&entity=<?= $entity ?>&id=<?= $row['id'] ?>"
                                        class="btn btn-sm btn-danger">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="<?= BASE_URL ?>" class="btn btn-link mt-3">← Volver al inicio</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+1mqVI44l9vYh3Q+YfkvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
</body>

</html>