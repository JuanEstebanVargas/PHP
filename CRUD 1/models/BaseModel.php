<?php
// models/BaseModel.php

abstract class BaseModel
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = getDatabaseConnection();
    }

    //DEFINIMOS LOS METODOS PARA CRUD

    // Devuelve todos los registros de una tabla
    public function findAll(string $table): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Devuelve un registro por ID
    public function findById(string $table, int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    // Inserta un nuevo registro (espera $data como array asociativo campo=>valor)
    public function insert(string $table, array $data): bool
    {
        $cols   = array_keys($data);
        $values = array_values($data);
        $placeholders = array_map(fn($c) => ':' . $c, $cols);

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $table,
            implode(',', $cols),
            implode(',', $placeholders)
        );
        $stmt = $this->pdo->prepare($sql);
        foreach ($data as $col => $val) {
            $stmt->bindValue(":{$col}", $val);
        }
        return $stmt->execute();
    }

    // Actualiza un registro por ID
    public function update(string $table, array $data, int $id): bool
    {
        $fields = [];
        foreach ($data as $col => $_) {
            $fields[] = "{$col} = :{$col}";
        }
        $sql = sprintf(
            "UPDATE %s SET %s WHERE id = :id",
            $table,
            implode(', ', $fields)
        );
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        foreach ($data as $col => $val) {
            $stmt->bindValue(":{$col}", $val);
        }
        return $stmt->execute();
    }

    // Elimina un registro por ID
    public function delete(string $table, int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
