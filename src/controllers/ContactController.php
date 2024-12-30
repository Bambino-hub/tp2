<?php

namespace App\controllers;

defined("ROOTPATH") or exit("access Denied");

class ContactController extends Controller
{
    public function contact()
    {
        $this->renderView("contact/contact");
    }
}
