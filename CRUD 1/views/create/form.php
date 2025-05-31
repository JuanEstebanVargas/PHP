<?php

/**
 * views/create/form.php
 * Variables disponibles:
 *   - $entity (string): 'users', 'products' u 'orders'
 *   - Si viene de edición, $row contiene los datos actuales; si no, $row no existe.
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= isset($row) ? 'Editar ' : 'Crear ' ?><?= ucfirst($entity) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4"><?= isset($row) ? 'Editar ' : 'Crear ' ?><?= ucfirst($entity) ?></h1>

        <form action="<?= BASE_URL ?>index.php?action=<?= isset($row) ? 'update' : 'create' ?>" method="post">
            <input type="hidden" name="entity" value="<?= htmlspecialchars($entity) ?>">
            <?php if (isset($row)): ?>
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <?php endif; ?>

            <?php if ($entity === 'users'): ?>
                <!-- Campo Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text"
                        class="form-control"
                        id="username"
                        name="username"
                        value="<?= isset($row) ? htmlspecialchars($row['username']) : '' ?>"
                        required>
                </div>

                <!-- Campo Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        value="<?= isset($row) ? htmlspecialchars($row['email']) : '' ?>"
                        required>
                </div>

                <!-- Campo Password (solo en creación o nueva contraseña en edición) -->
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <?= isset($row) ? 'Contraseña nueva (opcional)' : 'Contraseña' ?>
                    </label>
                    <input type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        <?= isset($row) ? '' : 'required' ?>>
                </div>

            <?php elseif ($entity === 'products'): ?>
                <!-- Campo Nombre -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre del producto</label>
                    <input type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        value="<?= isset($row) ? htmlspecialchars($row['name']) : '' ?>"
                        required>
                </div>

                <!-- Campo Descripción -->
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control"
                        id="description"
                        name="description"
                        rows="3"
                        required><?= isset($row) ? htmlspecialchars($row['description']) : '' ?></textarea>
                </div>

                <!-- Campo Precio -->
                <div class="mb-3">
                    <label for="price" class="form-label">Precio</label>
                    <input type="number"
                        step="0.01"
                        class="form-control"
                        id="price"
                        name="price"
                        value="<?= isset($row) ? $row['price'] : '' ?>"
                        required>
                </div>

            <?php elseif ($entity === 'orders'): ?>
                <!-- Campo User ID -->
                <div class="mb-3">
                    <label for="user_id" class="form-label">ID del usuario</label>
                    <input type="number"
                        class="form-control"
                        id="user_id"
                        name="user_id"
                        value="<?= isset($row) ? $row['user_id'] : '' ?>"
                        required>
                </div>

                <!-- Campo Product ID -->
                <div class="mb-3">
                    <label for="product_id" class="form-label">ID del producto</label>
                    <input type="number"
                        class="form-control"
                        id="product_id"
                        name="product_id"
                        value="<?= isset($row) ? $row['product_id'] : '' ?>"
                        required>
                </div>

                <!-- Campo Cantidad -->
                <div class="mb-3">
                    <label for="quantity" class="form-label">Cantidad</label>
                    <input type="number"
                        class="form-control"
                        id="quantity"
                        name="quantity"
                        value="<?= isset($row) ? $row['quantity'] : '1' ?>"
                        min="1"
                        required>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">
                <?= isset($row) ? 'Actualizar' : 'Crear' ?>
            </button>
            <a href="<?= BASE_URL ?>index.php?action=read&entity=<?= $entity ?>" class="btn btn-secondary ms-2">
                Cancelar
            </a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+1mqVI44l9vYh3Q+YfkvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
</body>

</html>