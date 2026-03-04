<?php

namespace App\Applicacion;

use Dominio\Auto;
use Infraestructura\AutoRepositorio;

class AgregarAuto
{
    public function agregar(Auto $auto): bool
    {
        try {
            $repo = new AutoRepositorio();
            $auto->validar();
            $result = $repo->agregar($auto);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
