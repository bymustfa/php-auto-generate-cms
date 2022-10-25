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
        try {
            $datas = MediaLibrary::all();
            response([
                'status' => true,
                'message' => 'Media Library Get All Success',
                'data' => [
                    'count' => $datas->count(),
                    'data' => $datas,
                ]
            ]);
        } catch (\Exception $e) {
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function GetOne($id)
    {
        try {
            $media = MediaLibrary::find($id);
            response([
                'status' => true,
                'message' => 'Media Library Get One Success',
                'data' => $media
            ]);
        } catch (\Exception $e) {
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function DeleteMedia($id)
    {
        try {
            $media = MediaLibrary::find($id);
            if ($media) {
                $mediaPath = $media->media_paths;
                $jsonData = json_decode($mediaPath, true);

                if (isset($jsonData)) {
                    $pathKeys = array_keys($jsonData);
                    foreach ($pathKeys as $key) {
                        $path = $jsonData[$key];
                        $path = __DIR__ . "/../../uploads/" . $path;
                        if (file_exists($path)) {
                            unlink($path);
                        }
                    }
                } else {
                    $path = __DIR__ . "/../../uploads/" . $mediaPath;

                    if (file_exists($path)) {
                        unlink($path);
                    }
                }


                $delete = $media->delete();
                if ($delete) {
                    response([
                        'status' => true,
                        'message' => 'Media Library Delete Success'
                    ]);
                } else {
                    throw new \Exception("Media Library Delete Failed");
                }
            } else {
                throw new \Exception("Media Not Found");

            }
        } catch (\Exception $e) {
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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

    public function FilterMedia(Request $request)
    {
        try {

            $filterBody = json_decode($request->getContent(), true);

            if (!isset($filterBody) || count($filterBody) === 0 || empty($filterBody) || !is_array($filterBody)) {
                throw new \Exception("Filter Body is Empty");
            }

            $filterArray = [];
            if (isset($filterBody) && is_array($filterBody)) {
                foreach ($filterBody as $filter) {
                    $filterArray[] = [$filter['field'], $filter['operator'], $filter['value']];
                }
            }
            $data = MediaLibrary::where($filterArray)->get();
            response([
                'status' => true,
                'message' => 'Media Library Filter Success',
                'data' => [
                    'count' => $data->count(),
                    'data' => $data
                ]
            ]);


        } catch (\Exception $e) {
            response([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }


}


?>
