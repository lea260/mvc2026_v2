<?php

namespace Infraestructura;

use Dominio\Usuario;
use Core\Conexion;
use PDO;

class UsuarioRepositorio
{
    public function __construct()
    {
        // Constructor vacío, conexión se obtiene en cada método
    }

    public function obtenerPorId(int $id): ?Usuario
    {
        $pdo = Conexion::getPDOConnection();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new Usuario($row['id'], $row['nombre'], $row['correo_electronico']);
    }
}
