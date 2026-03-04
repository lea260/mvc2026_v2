<?php

namespace Infraestructura;

use Core\Conexion;
use Dominio\Venta;
use PDO;

class VentaRepositorio
{

    public function __construct() {}

    public function registrar(Venta $venta): bool
    {
        $result = false;
        $pdo = null;
        $stmt = null;
        try {
            $pdo = Conexion::getPDOConnection();
            $stmt = $pdo->prepare("
            INSERT INTO venta (id_auto, id_vendedor, fecha_venta, precio)
            VALUES (?, ?, ?, ?)
        ");
            $result = $stmt->execute([
                $venta->getAuto()->getId(),
                $venta->getVendedor()->getId(),
                $venta->getFechaVenta()->format('Y-m-d H:i:s'),
                $venta->getPrecio()
            ]);
            return  $result;
        } catch (\Exception $e) {
            error_log("Error al registrar la venta: " . $e->getMessage());
            return false;
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }
}
