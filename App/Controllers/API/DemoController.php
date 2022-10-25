<?php
namespace App\Controllers\API;

use App\Controllers\API\Heleley\Demo;
use Symfony\Component\HttpFoundation\Request;

use App\Models\API\RestourantModel;

class DemoController extends Demo
{


    public function GetAll()
    {
        try {

            response([
                'status' => true,
                'message' => 'All data fetched successfully',
                'data' => [
                    'count' => 0,
                    'data' => $path
                ]
            ]);
        } catch (\Exception $e) {
            response([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ]);
        }
    }

}

?>
