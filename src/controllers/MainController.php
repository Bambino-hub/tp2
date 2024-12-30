<?php

namespace App\controllers;

class MainController extends Controller
{
    public function index()
    {
        return $this->renderView("home/home");
    }
}
