<?php
// models/ProductModel.php

require_once __DIR__ . '/BaseModel.php';

class ProductModel extends BaseModel
{
    // Nombre de la tabla en la BD
    protected $table = 'products';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Busca productos cuyo campo `name` coincida con $name.
     * Si $partial es true, usa LIKE (o ILIKE en PostgreSQL) para coincidencias parciales.
     *
     * @param string $name     Texto a buscar.
     * @param bool   $partial  Si es true, la consulta será "%$name%" para coincidencias parciales.
     * @return array           Arreglo de resultados (array asociativo). Si no hay coincidencias, devuelve [].
     */
    public function findByName(string $name, bool $partial = false): array
    {
        // Asegúrate de que $this->table siempre se define correctamente (en este caso, 'products').
        $table = $this->table;

        if ($partial) {
            // En PostgreSQL conviene usar ILIKE para búsqueda case-insensitive.
            $sql   = "SELECT * FROM {$table} WHERE name ILIKE :name";
            $param = '%' . $name . '%';
        } else {
            $sql   = "SELECT * FROM {$table} WHERE name = :name";
            $param = $name;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['name' => $param]);

        // fetchAll devuelve un array de filas; si no hay resultados, devuelve un array vacío.
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
