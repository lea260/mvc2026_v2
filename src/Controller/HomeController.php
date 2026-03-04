<?php
// El namespace debe empezar con el prefijo definido (App) 
// seguido del nombre de la carpeta (Controller)
namespace App\Controller;

class HomeController
{
    public function index()
    {
        echo "¡Hola! Estás en la Home.";
        //cargo la vista
        // http: //localhost:8080/index.php/productos/ver/5/verde
    }
}
