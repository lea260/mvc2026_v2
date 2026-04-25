<?php

namespace App\Controller;

use App\Aplicacion\ListarAutos;
use App\Core\View;
use Exception;

class AutosController
{
    // $id recibirá "15", $color recibirá "azul"
    public function listar()
    {
        // View::render('autos/listar', ['nombre' => $nombre]);

        $autos = [];
        try {
            $casoUso = new ListarAutos();
            $autos = $casoUso->ejecutar();
            View::render('autos/listar', ['autos' => $autos]);
        } catch (Exception $e) {
            View::render('mensaje/comun.php', [
                'titulo' => 'Error al obtener los autos',
                'mensaje' => $e->getMessage(),
            ]);
        }
    }
}
