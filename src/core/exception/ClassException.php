<?php

namespace App\core\exception;

defined("ROOTPATH") or exit("access Denied");


use App\controllers\Controller;

class ClassException extends \Exception
{
    //on recoit la qui n'existe pas 
    private $classe;

    // on recoit le controller pour utliser la function renderView
    public Controller $controller;

    public function __construct($classe = null)
    {
        $this->controller = new Controller;
        $this->classe = $classe;
    }

    /**
     * cette fonction affiche les erreurs de la classe non trouvée
     */
    public function classerror()
    {
        $this->controller->response->setStatus(404);
        $this->controller->renderView("errors/class_404", ["classe" => $this->classe]);
    }
}
