<?php
//activar el modo estricto de tipos
declare(strict_types=1);

require_once __DIR__ . '/Entidad.php';

/**
 * ========================================================
 * 👤 Clase Producto
 * Representa una fila de la tabla 'productos'
 * Hereda de Entidad (que contiene el id y utilidades comunes)
 * ========================================================
 */
class Producto extends Entidad
{
    public string $nombre = '';
    public double $precio  = 0.0;

    /**
     * Convierte el objeto en un array (útil para debug o JSON).
     */
    public function toArray(): array
    {
        return [
            'id'      => $this->getId(),
            'nombre'  => $this->nombre,
            'precio'     => $this->precio,
        ];
    }
}