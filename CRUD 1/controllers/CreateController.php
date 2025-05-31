<?php
// controllers/CreateController.php

require_once __DIR__ . '/../models/BaseModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/OrderModel.php';


class CreateController
{
    public function __construct()
    {
        // nada aquí por ahora
    }

    /**
     * Recibe $_POST + parámetro “entity” vía GET o POST.
     * $entity podría ser “users”, “products” u “orders”.
     */
    public function create(array $postData): void
    {
        if (empty($postData['entity'])) {
            die('Falta especificar la entidad.');
        }
        $entity = $postData['entity'];
        unset($postData['entity']);

        // Creamos dinámicamente el modelo correcto
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

        // Insertar datos
        unset($postData['id']); // si exists
        $ok = $model->insert($entity, $postData);
        if ($ok) {
            header("Location: ../public/index.php?action=read&entity={$entity}");
            exit;
        } else {
            echo "Error al crear en {$entity}.";
        }
    }
}
