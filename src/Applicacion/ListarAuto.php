<?php

namespace App\Applicacion;

use Infraestructura\AutoRepositorio;

class ListarAuto
{
    public function listar()
    {
        try {
            $repo = new AutoRepositorio();
            return $repo->listar();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
