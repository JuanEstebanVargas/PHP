<?php
// models/UserModel.php

require_once __DIR__ . '/BaseModel.php';

class OrderModel extends BaseModel
{
    protected $table = 'orders';

    public function __construct()
    {
        parent::__construct();
    }

    // Ejemplo de método específico:
    public function findByDate(string $order_date): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE order_date = :order_date");
        $stmt->execute(['order_date' => $order_date]);
        return $stmt->fetch() ?: null;
    }
}
