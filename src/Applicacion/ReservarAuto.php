<?php

namespace Applicacion;

use Core\Conexion;
use Dominio\Auto;
use Dominio\Reserva;
use Exception;
use Infraestructura\AutoRepositorio;
use Infraestructura\ReservaRepositorio;
use Infraestructura\UsuarioRepositorio;

class ReservarAuto
{
    public function ejecutar(int $idUsuario, int $idAuto): void
    {
        $pdo = Conexion::getPDOConnection();
        $pdo->beginTransaction();
        try {
            $autoRepo = new AutoRepositorio($pdo);
            $usuarioRepo = new UsuarioRepositorio($pdo);
            $reservaRepo = new ReservaRepositorio();
            $auto = $autoRepo->obtenerPorId($idAuto);
            $usuario = $usuarioRepo->obtenerPorId($idUsuario);
            if (!$auto || !$usuario) {
                throw new Exception("Auto o usuario no encontrado.");
            }
            if ($auto->getEstado() !== 'disponible') {
                throw new Exception("El auto no está disponible para reservar.");
            }
            $auto->reservar();
            $autoRepo->actualizar($auto);
            $reserva = new Reserva(
                auto: $auto,
                usuario: $usuario,
                fechaReserva: new \DateTime()
            );
            $reservaRepo->reservar($reserva);
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
