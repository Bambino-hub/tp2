<?php

namespace App\core;

defined("ROOTPATH") or exit("access Denied");

use App\core\Request;
use App\core\exception\ClassException;
use App\core\exception\FunctionException;



class Route
{
    private string $params;
    public Request $request;
    public Response $response;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function run():void
    {
        // demarre la session
        session_start();

        // on appelle la function de redirection d'url sans le slash
        $this->request->redirectUri();

        // on recupère les paramètre
        $this->params = $this->request->getParams() ?? 'main';
        
        $params = explode("/", $this->params);

        // on verife si on a au moins un paramètre
        if ($params[0] != '') {

            // si le premier paramètre exite alors c'est le contolleur
            // on recupère le controller a instancie avec son namespace complet
            $controller = '\\App\\controllers\\' . ucfirst(array_shift($params)) . 'Controller';

            // si la classe existe on l'instnacie 
            if (class_exists($controller)) {

                // on instancie le controller
                $controller = new $controller($this->request, $this->response);
            } else {
                // echo 'la class ' . $controller . ' n\'existe pas';
                // si la classe n'existe pas on lance une exception
                throw new ClassException($controller);
            }

            // on verifie si le deuxieme paramètre existe Si oui c'est la méthod
            $action = isset($params[0]) ? array_shift($params) : 'index';

            // on verife si la méthod existe dans le controller
            if (method_exists($controller, $action)) {

                // s'il reste des paramètre on les passe a la méthod
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {

                // si la method n'existe pas on lance une exception
                throw new FunctionException($action);
            }
        }
    }

}
