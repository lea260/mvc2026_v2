<?php

namespace Dominio;

class Venta
{
    private int $id;
    private Auto $auto;
    private Usuario $vendedor;
    private \DateTime $fechaVenta;
    private  float $precio;

    public function __construct(Auto $auto, Usuario $vendedor, float $precio, ?int $id = null, ?\DateTime $fechaVenta = null)
    {
        $this->auto = $auto;
        $this->vendedor = $vendedor;
        $this->precio = $precio;
        $this->fechaVenta = $fechaVenta ?? new \DateTime();
        $this->id = $id ?? 0;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getAuto(): Auto
    {
        return $this->auto;
    }
    public function getVendedor(): Usuario
    {
        return $this->vendedor;
    }
    public function getFechaVenta(): \DateTime
    {
        return $this->fechaVenta;
    }

    public function getIdAuto(): int
    {
        return $this->auto->getId();
    }

    public function getFecha(): \DateTime
    {
        return $this->fechaVenta;
    }
    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function validarPrecio(float $precio): void
    {
        if ($precio <= 0) {
            throw new \InvalidArgumentException("El precio debe ser mayor a cero.");
        }
    }
}
