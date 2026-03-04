<?php

//$path ="var/www/html";
$path = dirname(__DIR__, 2);
define('BASE_PATH', dirname(__DIR__, 2));
// define('BASE_PATH', $path); // apunta a src/ /var/html/www
define('BASE_URL', 'http://localhost:8080/');
define('BASE_URL_CTRL', 'http://localhost:8080/controller/');
// define('BASE_URL_VIEW', 'http://localhost:8080/view/');
require_once BASE_PATH . '/config/bootstrap.php';



use Applicacion\ListarAuto;
use Core\View;
// require_once 'config/config.php';
// require_once 'infraestructura/AutoRepositorio.php';


$autos = [];

try {
    $casoUso = new ListarAuto();
    $autos = $casoUso->listar();
    $json = [
        'autos' => $autos,
        'total' => count($autos)
    ];
    View::render('api/render.php', [
        'codigo' => '200',
        'respuesta' => json_encode($json)
    ]);
} catch (Exception $e) {
    View::render('mensaje/comun.php', [
        'codigo' => 400,
        'respuesta' => $e->getMessage(),
    ]);
}
