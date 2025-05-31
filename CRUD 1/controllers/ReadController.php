<?php
// controllers/ReadController.php

require_once __DIR__ . '/../models/BaseModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/OrderModel.php';

class ReadController
{
    public function listAll(string $entity): void
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

        $rows = $model->findAll($entity);
        // Incluir la vista “views/read/list.php”
        include __DIR__ . "/../views/read/list.php";
    }

    public function detail(string $entity, int $id): void
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
        include __DIR__ . "/../views/read/detail.php";
    }
}
