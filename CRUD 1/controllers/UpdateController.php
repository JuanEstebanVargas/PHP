<?php
// controllers/UpdateController.php

require_once __DIR__ . '/../models/BaseModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/OrderModel.php';

class UpdateController
{
    public function showForm(string $entity, int $id): void
    {
        // Obtener el registro a editar
        switch ($entity) {
            case 'users':
                $model = new UserModel();
                break;
            case 'products':
                $model = new ProductModel();
                break;
            case 'orders':
                $model = new OrderModel();
                break;
            default:
                die("Entidad desconocida: $entity");
        }

        $row = $model->findById($entity, $id);
        include __DIR__ . "/../views/create/form.php";
    }

    public function update(array $postData): void
    {
        if (empty($postData['entity']) || empty($postData['id'])) {
            die('Faltan parámetros.');
        }
        $entity = $postData['entity'];
        $id     = (int)$postData['id'];
        unset($postData['entity'], $postData['id']);

        switch ($entity) {
            case 'users':
                $model = new UserModel();
                break;
            case 'products':
                $model = new ProductModel();
                break;
            case 'orders':
                $model = new OrderModel();
                break;
            default:
                die("Entidad desconocida: $entity");
        }

        $ok = $model->update($entity, $postData, $id);
        if ($ok) {
            header("Location: ../public/index.php?action=read&entity={$entity}");
            exit;
        } else {
            echo "Error al actualizar en {$entity}.";
        }
    }
}
