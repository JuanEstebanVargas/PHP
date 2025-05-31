<?php
// public/index.php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/controllers/CreateController.php';
require_once __DIR__ . '/controllers/ReadController.php';
require_once __DIR__ . '/controllers/UpdateController.php';
require_once __DIR__ . '/controllers/DeleteController.php';

// Obtener parámetros de ruta (o definir valores por defecto)
$action = $_GET['action']    ?? $_POST['action']    ?? 'home';
$entity = $_GET['entity']    ?? $_POST['entity']    ?? null;
$id     = isset($_GET['id']) ? (int)$_GET['id'] : null;

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ctrl = new CreateController();
            $ctrl->create($_POST);
        } else {
            // Mostrar formulario de creación
            if (!$entity) die('Entidad no especificada');
            // Reutilizamos el form.php de “create”
            require_once __DIR__ . "/views/create/form.php";
        }
        break;

    case 'read': // Listado
        if (!$entity) die('Entidad no especificada');
        $ctrl = new ReadController();
        $ctrl->listAll($entity);
        break;

    case 'readDetail':
        if (!$entity || !$id) die('Faltan parámetros');
        $ctrl = new ReadController();
        $ctrl->detail($entity, $id);
        break;

    case 'updateForm':
        if (!$entity || !$id) die('Faltan parámetros');
        $ctrl = new UpdateController();
        $ctrl->showForm($entity, $id);
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ctrl = new UpdateController();
            $ctrl->update($_POST);
        } else {
            die('Método no permitido');
        }
        break;

    case 'deleteConfirm':
        if (!$entity || !$id) die('Faltan parámetros');
        $ctrl = new DeleteController();
        $ctrl->confirm($entity, $id);
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ctrl = new DeleteController();
            $ctrl->delete($_POST['entity'], (int)$_POST['id']);
        } else {
            die('Método no permitido');
        }
        break;

    case 'home':
    default:
        // Página de inicio genérica: por ejemplo, enlaces a cada entidad
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <title>CRUD Genérico</title>
            <link rel="stylesheet" href="styles.css">
        </head>

        <body>
            <h1>Panel de Control</h1>
            <ul>
                <li><a href="index.php?action=read&entity=users">Usuarios</a></li>
                <li><a href="index.php?action=read&entity=products">Productos</a></li>
                <li><a href="index.php?action=read&entity=orders">Órdenes</a></li>
            </ul>
        </body>

        </html>
<?php
        break;
}
