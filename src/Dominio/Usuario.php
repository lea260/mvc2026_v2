<?php

namespace App\Dominio;

class Usuario
{
    private int $id;
    private string $nombre;
    private string $correo;

    public function __construct(int $id, string $nombre, string $correo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function getCorreo(): string
    {
        return $this->correo;
    }
    public function reservarAuto(Auto $auto): void
    {
        $auto->reservar();
    }
    public function __toString(): string
    {
        return "Usuario: {$this->nombre}, Correo: {$this->correo}";
    }
};
