<?php

namespace Infraestructura;

use Dominio\Auto;

interface AutoRepositorioInterface
{
    public function guardar(Auto $car): bool;
    public function buscarPorPatente(string $patente): ?Auto;
    public function actualizar(Auto $auto): void;
}
