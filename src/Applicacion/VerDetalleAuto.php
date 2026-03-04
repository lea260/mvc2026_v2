<?php

namespace Applicacion;

use Dominio\Auto;
use Exception;
use Infraestructura\AutoRepositorio;

class VerDetalleAuto
{
    // public function listar(): array
    // {
    //     $repo = new AutoRepositorio();
    //     return $repo->listarDisponibles();
    // }
    // Si necesitas ver el detalle de un solo auto por id:
    public function obtenerPorId(int $id): ?Auto
    {
        try {
            $repo = new AutoRepositorio();
            return $repo->obtenerPorId($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
