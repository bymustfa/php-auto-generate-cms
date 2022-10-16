<?php

namespace App\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Core\Upload;
use Core\Controller;


class MediaLibraryController extends Controller
{
    public function GetAll()
    {
        echo "Get All ";
    }

    public function GetOne($id)
    {
        echo "Get One " . $id;
    }


    public function AddMedia(Request $request)
    {
        try {
            $files = $_FILES['files'];

            $uploadFiles = [];
            $errorFiles = [];
            foreach ($files['name'] as $key => $value) {

                $file = [
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key],
                ];
                $upload = new Upload($file);
                $uploadFile = $upload->upload();

                if ($uploadFile && $uploadFile['status']) {
                    $uploadFiles[] = $uploadFile['data'];
                } else {
                    $errorFiles[] = $uploadFile['data'];
                }
            }

            response(['uploadFiles' => $uploadFiles, 'errorFiles' => $errorFiles], 200);


        } catch (\Exception $e) {
            response([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }

    }


}


?>
