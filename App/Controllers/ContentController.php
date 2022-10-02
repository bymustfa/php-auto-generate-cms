<?php

namespace App\Controllers;


use Core\Controller;

class ContentController extends Controller
{
    // GET: /content/list
    public function list()
    {
        return $this->view('content/list');
    }

    // GET: /content/create
    public function createPage()
    {
        return $this->view('content/create');
    }

    // POST: /content/create
    public function create()
    {
        echo "create";
    }
}
