<?php
namespace App\Controllers\API;

use Core\Controller;
use Symfony\Component\HttpFoundation\Request;

class DemoController extends Controller
{
    public function GetAll(Request $request)
    {
        response([
            'status' => true,
            'message' => 'Demoo'
        ]);
    }

}

?>
