<?php

namespace App\Dominio;

use Dominio\Auto;
use Dominio\Usuario;

class Reserva
{
    private Auto $auto;
    private Usuario $usuario;
    private \DateTime $fechaReserva;

    public function __construct(Auto $auto, Usuario $usuario, \DateTime $fechaReserva)
    {
        $this->auto = $auto;
        $this->usuario = $usuario;
        $this->fechaReserva = $fechaReserva;
    }

    public function getAuto(): Auto
    {
        return $this->auto;
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    public function getFechaReserva(): \DateTime
    {
        return $this->fechaReserva;
    }
}
