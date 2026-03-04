<?php

namespace Infraestructura;

use Core\Conexion;
use Dominio\Auto;
use PDO;
use PDOException;

class AutoRepositorio
{

    public function __construct() {}

    public function actualizar(Auto $auto): void
    {
        $pdo = Conexion::getPDOConnection();
        $stmt = $pdo->prepare("
            UPDATE auto 
            SET estado = :estado, version = :nueva_version
            WHERE id = :id AND version = :version_actual
        ");

        $stmt->execute([
            'estado' => $auto->getEstado(),
            'nueva_version' => $auto->getVersion(),
            'id' => $auto->getId(),
            'version_actual' => $auto->getVersion() - 1
        ]);
        if ($stmt->rowCount() === 0) {
            throw new \Exception("Conflicto de concurrencia: el auto fue modificado por otro proceso.");
        }
    }

    public function obtenerPorId(int $id): ?Auto
    {
        try {
            $pdo = Conexion::getPDOConnection();
            $sql = "SELECT  id, patente,marca,modelo,estado FROM auto WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) return null;

            $auto = self::arrayToAuto($row);
            return $auto;
        } catch (PDOException $e) {
            error_log("Error al conectar a la base de datos: " . $e->getMessage());
            throw new \Exception("Error al conectar a la base de datos.");
        }
    }
    public function agregar(Auto $auto): bool
    {
        $result = false;
        $pdo = null;
        try {
            $pdo = Conexion::getPDOConnection();
            $stmt = $pdo->prepare("
            INSERT INTO auto (patente, marca, modelo, estado) 
            VALUES (:patente, :marca, :modelo, :estado)
            ");


            $result = $stmt->execute([
                ':patente' => $auto->getPatente(),
                ':marca' => $auto->getMarca(),
                ':modelo' => $auto->getModelo(),
                ':estado' => $auto->getEstado()
            ]);
            return $result;
        } catch (PDOException $e) {
            error_log("Error al agregar auto: " . $e->getMessage());
            throw new \Exception("Error al agregar auto.");
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }

    public static function listar(): array
    {
        $pdo = null;
        $stmt = null;
        try {
            $pdo = Conexion::getPDOConnection();
            $sql = "SELECT id, patente,marca,modelo,estado, version FROM auto";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch()) {
                $auto = self::arrayToAuto($row);
                $autos[] = $auto;
            }
            //retornar los autos
            return $autos;
        } catch (PDOException $e) {
            error_log("Error al obtener autos: " . $e->getMessage());
            return [];
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }
    public static function listarDisponibles(): array
    {
        $pdo = null;
        $stmt = null;
        $autos = [];
        try {
            $pdo = Conexion::getPDOConnection();
            $sql = "SELECT id, patente,marca,modelo,estado, version FROM auto WHERE estado = 'disponible'";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch()) {
                $auto = self::arrayToAuto($row);
                $autos[] = $auto;
            }
            return $autos;
        } catch (PDOException $e) {
            error_log("Error al obtener autos disponibles: " . $e->getMessage());
            return [];
        } finally {
            $stmt = null;
            $pdo = null;
        }
    }
    private static function arrayToAuto(array $row): Auto
    {
        return new Auto(
            patente: $row['patente'],
            marca: $row['marca'],
            modelo: $row['modelo'],
            estado: $row['estado'],
            version: $row['version'] ?? 0,
            id: $row['id']
        );
    }
}
