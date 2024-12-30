<?php

namespace App\core;

defined("ROOTPATH") or exit("access Denied");


class Response
{
    /**
     * cette fonction nous permet de definir un status code 
     *
     * @param integer $status
     * @return void
     */
    public function setStatus(int $status)
    {
        http_response_code($status);
    }

    /**
     * cette fonction nous permet de faire une redirection
     *
     * @param string $url
     * @return void
     */
    public function redirect(string $url)
    {
        header("Location:" . ROOT . '/' . $url);
    }
}
