<?php

namespace App\Controllers;

use Core\Controller;

class FrontController extends Controller
{

    // GET: /login
    public function Login()
    {
        return $this->view('login');
    }

    // GET: /
    public function Index()
    {

//        $generator = new \Core\Generator();
//
//        $schema = $generator->createSchema("restaurants", [
//            "name" => [
//                'type' => 'string',
//                'default' => null,
//                'min' => 3,
//                'max' => 50,
//            ],
//            "stars" => [
//                'type' => 'number',
//                'default' => 1,
//                'min' => 1,
//                'max' => 5,
//            ],
//            "address" => [
//                'type' => 'string',
//                'default' => null,
//                'min' => 10,
//                'max' => 255,
//            ],
//            "status" => [
//                'type' => 'boolean',
//                'default' => 1,
//            ],
//        ]);


        return $this->view('home');
    }


    // GET: content/list
    public function ContentList()
    {
        return $this->view('content/list');
    }

    // GET: content/create
    public function ContentCreate()
    {
        return $this->view('content/create');
    }

    // GET: media/list
    public function MediaList()
    {
        return $this->view('media/list');
    }

    // GET: media/create
    public function MediaCreate()
    {
        return $this->view('media/create');
    }
}

