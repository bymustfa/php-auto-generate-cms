<?php

namespace App\Controllers;

use Core\Controller;

class FrontController extends Controller
{

    public function Login()
    {
        return $this->view('login');
    }

    public function Index()
    {
        return $this->view('home');
    }
}

