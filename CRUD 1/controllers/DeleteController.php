<?php
// controllers/DeleteController.php

require_once __DIR__ . '/../models/BaseModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/OrderModel.php';

class DeleteController
{
    public function confirm(string $entity, int $id): void
    {
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
        include __DIR__ . "/../views/delete/confirm.php";
    }

    public function delete(string $entity, int $id): void
    {
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

        $ok = $model->delete($entity, $id);
        if ($ok) {
            header("Location: ../public/index.php?action=read&entity={$entity}");
            exit;
        } else {
            echo "Error al eliminar en {$entity}.";
        }
    }
}
