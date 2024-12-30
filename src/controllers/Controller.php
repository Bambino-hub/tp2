<?php

namespace App\controllers;

defined("ROOTPATH") or exit("access Denied");

use App\core\Request;
use App\core\Response;

class Controller
{
    public Request $request;
    public Response $response;

    public function __construct()
    {
        $this->request = new Request;
        $this->response = new Response;
    }

    public function renderView(string $viewPath, $adta = [], $template = 'default')
    {
        // on extrait les données
        extract($adta);

        // on demarre le buffer de sortie
        ob_start();

        // on envoies les informations a notre vue
        require_once VIEW_ROOT . $viewPath . '.php';

        $content = ob_get_clean();

        require_once VIEW_ROOT . $template . '.php';
    }
}
