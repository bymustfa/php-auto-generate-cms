<?php

namespace App\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Core\Upload;
use Core\Controller;

use App\Models\MediaLibrary;


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
            MediaLibrary::beginTransaction();
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

                    $data = $uploadFile['data'];
                    $uploadFiles[] = [
                        'media_guid' => $data['newFileGuid'],
                        'media_name' => $data['fileName'],
                        'media_type' => $data['fileType'],
                        'media_ext' => $data['fileExtension'],
                        'media_paths' => is_array($data['fileUrl']) ? json_encode($data['fileUrl']) : $data['fileUrl'],
                        'media_size' => $data['fileSize']
                    ];
                } else {
                    $errorFiles[] = $uploadFile['data'];
                }
            }


            foreach ($uploadFiles as $key => $value) {
                $add = MediaLibrary::create($value);
                if (!$add) {
                    throw new \Exception("Error Processing Request", 1);
                } else {
                    $id = $add->id;
                    $uploadFiles[$key]['id'] = $id;
                }
            }

            MediaLibrary::commit();
            response([
                'status' => true,
                'message' => 'Media Add',
                'data' => ['uploadFiles' => $uploadFiles, 'errorFiles' => $errorFiles]
            ], 200);


        } catch (\Exception $e) {
            MediaLibrary::rollBack();
            response([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }

    }


}


?>
