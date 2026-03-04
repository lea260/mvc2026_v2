<?php

namespace Infraestructura;

use Core\Conexion;
use Dominio\Reserva;
use PDO;

class ReservaRepositorio
{
    public function __construct() {}

    public function reservar(Reserva $reserva): bool
    {
        $result = false;
        $pdo = null;
        $stmt = null;
        try {
            $pdo = Conexion::getPDOConnection();
            $stmt = $pdo->prepare("
                INSERT INTO reserva (id_auto, id_usuario, fecha_reserva)
                VALUES (?, ?, ?)
            ");
            $result = $stmt->execute([
                $reserva->getAuto()->getId(),
                $reserva->getUsuario()->getId(),
                $reserva->getFechaReserva()->format('Y-m-d H:i:s')
            ]);
            return $result;
        } catch (\Exception $e) {
            error_log("Error al registrar la reserva: " . $e->getMessage());
            return false;
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }
}
