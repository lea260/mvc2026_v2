<?php

namespace App\Applicacion;

use Core\Conexion;
use Dominio\Venta;
use Exception;
use Infraestructura\AutoRepositorio;
use Infraestructura\UsuarioRepositorio;
use Infraestructura\VentaRepositorio;

class RegistrarVenta
{

    public function __construct() {}

    public function ejecutar(int $idAuto, int $idVendedor, float $precio): void
    {
        $pdo = Conexion::getPDOConnection();
        $pdo->beginTransaction();

        try {
            $ventaRepo = new VentaRepositorio();
            $autoRepo = new AutoRepositorio($pdo);
            $usuarioRepo = new UsuarioRepositorio($pdo);
            $auto = $autoRepo->obtenerPorId($idAuto);
            $vendedor = $usuarioRepo->obtenerPorId($idVendedor);

            if (!$auto || !$vendedor) {
                throw new Exception("Auto o usuario no encontrado.");
            }

            if ($auto->getEstado() !== 'disponible') {
                throw new Exception("El auto no está disponible para vender.");
            }

            // Lógica de negocio
            $auto->vender();

            $autoRepo->actualizar($auto);

            $venta = new Venta(
                auto: $auto,
                vendedor: $vendedor,
                precio: $precio,
                fechaVenta: new \DateTime()
            );
            $venta->validarPrecio($precio);
            $ventaRepo->registrar($venta);
            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        } finally {
            $pdo = null;
            Conexion::cerrar();
        }
    }
}
