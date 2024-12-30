<?php

namespace App\core;

defined("ROOTPATH") or exit("access Denied");


class Request
{
    // on recupère la class  Response 
    public Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    /**
     * cette fonction nous permet de redirigé une url sans le slash
     *
     * @return void
     */
    public function redirectUri()
    {
        $uri = $_SERVER['REQUEST_URI'];

        //on verifie si l'url n'est pas vide, n'est pas un '/' ou se termine par un '/'
        // on retire les slash et on redirige vers l'uri sans slash
        if (!empty($uri) && $uri !== '/' && $uri[-1] === '/') {

            $uri = substr($uri, 0, -1);
            $this->response->setStatus(301);
            $this->response->redirect($uri);
        }
    }

    /**
     * cette fonction nous permet de recuperer les paramètres passé en url
     *
     * @return void
     */
    public function getParams()
    {
        $params = $_GET["url"] ?? 'users/register';
        return $params;
    }
    /**
     * cette fonction nous renvoie la methode get ou post
     *
     * @return void
     */
    public function getMethod():string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    /**
     * cette fonction recupère la méthode get
     *
     * @return boolean
     */
    public function isGet() 
    {
        return $this->getMethod() === "get";
    }

    /**
     * cette fonction recupère la fonction post
     *
     * @return boolean
     */
    public function isPost()
    {
        return $this->getMethod() === "post";
    }

    /**
     * cette fonction recupère les données venants de $_POST ou de $_GET
     *et sécurise les donneés
     * @return void
     */
    public function getBody(): array           
    {

        $body = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}
