<?php
declare(strict_types=1);

require_once __DIR__ . '/DAO.php';
require_once __DIR__ . '/../Producto.php';

class ProductoDAO extends DAO
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'productos');
    }

    /**
     * Inserta o actualiza un producto.
     */
    public function guardar(object $entidad): bool
    {
        if (!($entidad instanceof Producto)) {
            throw new InvalidArgumentException('Se esperaba un objeto de tipo Producto');
        }

        $tieneId = (int)$entidad->getId() > 0;

        if ($tieneId) {
            $sql = "UPDATE {$this->tabla}
                SET nombre = :nombre,
                    precio  = :precio
                WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                return $stmt->execute([
                    ':nombre'  => $entidad->nombre,
                    ':precio'     => $entidad->precio,
                    ':id'      => $entidad->getId(),
                ]);
        }

        // INSERT
        $sql = "INSERT INTO {$this->tabla} (nombre, precio)
                VALUES (:nombre, :precio)";
        $stmt = $this->pdo->prepare($sql);
        $ok = $stmt->execute([
            ':nombre'   => $entidad->nombre,
            ':precio'      => $entidad->precio,
        ]);

        if ($ok) {
            $entidad->setId((int)$this->pdo->lastInsertId());
        }
        return $ok;
    }

    /**
     * Busca un producto por su ID.
     */
    public function buscarPorId(int $id): ?Producto
    {
        $stmt = $this->pdo->prepare("SELECT id, nombre, precio
                                    FROM {$this->tabla}
                                    WHERE id = :id
                                    LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $p = new Producto();
        $p->setId((int)$row['id']);
        $p->nombre  = $row['nombre'];
        $p->precio     = $row['precio'];
        return $p;
    }

    /**
     * Devuelve todos los productos
     * @return Producto[]
     */
    public function listar(): array
    {
        $stmt = $this->pdo->query("SELECT id, nombre, precio
                                    FROM {$this->tabla}
                                    ORDER BY id ASC");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $productos = [];
        while ($row = $stmt->fetch()) {
            $p = new Producto();
            $p->setId((int)$row['id']);
            $p->nombre  = $row['nombre'];
            $p->precio     = $row['precio'];
            $productos[] = $p;
        }
        return $productos;
    }

    /**
     * Busca un producto por su nombre
     */
    public function buscarPorNombre(string $producto): ?Producto
    {
        $stmt = $this->pdo->prepare("SELECT id, nombre, precio
                                    FROM {$this->tabla}
                                    WHERE nombre = :nombre
                                    LIMIT 1");
        $stmt->execute([':nombre' => $producto]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $p = new Producto();
        $p->setId((int)$row['id']);
        $p->nombre  = $row['nombre'];
        $p->precio     = $row['precio'];
        return $p;
    }
}