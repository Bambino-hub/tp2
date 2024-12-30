<?php

use App\core\Route;

use App\core\exception\ClassException;
use App\core\exception\FunctionException;

// on definie nos constante slash ou antislash
define("DS", DIRECTORY_SEPARATOR);

// on crée un chemin qui nous mène vers le dossier views
define("VIEW_ROOT", dirname(__DIR__) . "/views/");

// nous pemet de faire un lien vers une autre page 
define("ROOT", 'http://localhost/tp2');

// nous permet de ne pas accé a un fichier a patr l'index
define('ROOTPATH', __DIR__ . DS);

require_once dirname(__DIR__) . "/vendor/autoload.php";


$route = new Route();

try {
    $route->run();
} catch (ClassException $e) {
    echo $e->classerror();
} catch (FunctionException $e) {
    echo $e->function_404();
}
