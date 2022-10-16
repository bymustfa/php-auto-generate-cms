<?php


namespace App\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Core\Controller;


class ContentManagementController extends Controller
{
    public function GetAll()
    {
        echo "Get All ";
    }

    public function GetOne($id)
    {
        echo "Get One " . $id;
    }

    public function GetTypes()
    {
        echo "Get Types ";
    }
}

?>
