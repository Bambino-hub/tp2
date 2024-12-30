<?php

namespace App\core\exception;

defined("ROOTPATH") or exit("access Denied");


use App\controllers\Controller;
use Exception;

class FunctionException extends Exception
{
    //on recoit la qui n'existe pas 
    private $action;

    // on recoit le controller pour utliser la function renderView
    public Controller $controller;

    public function __construct($action = null)
    {
        $this->controller = new Controller;
        $this->action = $action;
    }

    /**
     * cette function affiche les erreurs des fonctions introuvables 
     *
     * @return void
     */
    public function function_404()
    {
        $this->controller->response->setStatus(404);
        $this->controller->renderView("errors/function_404", ["action" => $this->action]);
    }
}
