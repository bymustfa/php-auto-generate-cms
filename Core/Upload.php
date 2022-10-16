<?php

namespace Core;


class Upload
{

    public static $file;

    static $fileTypes = [
        'image' => [
            "jpeg",
            "png",
            "gif",
            "bmp",
            "webp",
            "svg+xml",
            "svg",
        ],
        'audio' => [
            "mpeg",
            "mp3",
            "ogg",
            "wav"
        ],
        'video' => [
            "mp4",
            "ogg",
            "webm",
            "avi",
            "mpeg",
            "quicktime"
        ]
    ];

    static $notAlowedTypes = [
        "application/x-php",
        "application/javascript",
        "application/x-javascript",
        "application/x-httpd-php",
        "application/x-httpd-php-source",
        "application/x-httpd-php3",
        "application/x-httpd-php3-preprocessed",
        "application/x-httpd-php4",
        "application/x-httpd-php5",
        "application/x-httpd-php7",
        "application/x-httpd-phps",
        "application/x-httpd-php-s",
        "application/x-httpd-php-source",
        "application/x-javascript",
        "application/x-shockwave-flash",
        "application/xhtml+xml",
        "application/xml",
        "application/xml-dtd",
        "application/xml-external-parsed-entity",
        "application/xslt+xml",
        "application/xspf+xml",
        "application/x-xpinstall",
        "application/zip",
        "application/x-gzip",
        "application/x-bzip2",
    ];

    public function __construct($file)
    {
        self::$file = $file;
        return $this;
    }


    private static function fileTypeDetect()
    {
        $fileType = self::$file['type'];

        foreach (self::$fileTypes as $key => $fileTypes) {
            foreach ($fileTypes as $type) {
                if (strpos($fileType, $type) !== false) {
                    return $key;
                }
            }
        }

    }

    private static function fileName()
    {
        $file = self::$file;
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $dateNow = date("Y_m_d_H_i_s");
        return $dateNow . "_" . guid() . "." . $fileExtension;

    }

    private static function getFileDetails()
    {
        $fileType = self::fileTypeDetect();
        $fileName = self::$file['name'];
        $fileSize = self::$file['size'];
        $fileTmpName = self::$file['tmp_name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = self::fileName();

        return [
            'fileType' => $fileType,
            'fileName' => $fileName,
            'fileSize' => $fileSize,
            'fileTmpName' => $fileTmpName,
            'fileExtension' => $fileExtension,
            'newFileName' => $newFileName,

        ];
    }

    private static function uploadImage()
    {
        try {
            $uploadDir = "images";
            $file = self::$file;

        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    private static function uploadAudio()
    {
        $fileDetails = self::getFileDetails();
        $fileData = [
            'fileType' => $fileDetails['fileType'],
            'fileName' => $fileDetails['fileName'],
            'fileSize' => $fileDetails['fileSize'],
            'fileExtension' => $fileDetails['fileExtension'],
        ];

        try {
            $uploadDir = "audios";

            $uploadDir = "uploads/" . $uploadDir . "/" . $fileDetails['newFileName'];
            if (move_uploaded_file($fileDetails['fileTmpName'], $uploadDir)) {


                return [
                    'status' => true,
                    'message' => "File uploaded successfully",
                    'data' => [
                        'fileType' => $fileDetails['fileType'],
                        'fileName' => $fileDetails['fileName'],
                        'fileSize' => $fileDetails['fileSize'],
                        'fileExtension' => $fileDetails['fileExtension'],
                        'newFileName' => $fileDetails['newFileName'],
                        'fileUrl' => $uploadDir,

                    ]
                ];
            } else {
                return [
                    'status' => false,
                    'message' => "File not uploaded",
                    'data' => $fileData
                ];
            }


        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => $fileData
            ];
        }
    }

    private static function uploadVideo()
    {
        try {
            $uploadDir = "video";
            $file = self::$file;

        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    private static function uploadFile()
    {
        try {
            $uploadDir = "files";
            $file = self::$file;

        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }


    public static function upload()
    {
        try {

            $postMaxSize = intval(ini_get('post_max_size')) * 1024 * 1024;
            $uploadMaxSize = intval(ini_get('upload_max_filesize')) * 1024 * 1024;
            $maxFileUploads = intval(ini_get('max_file_uploads')) * 1024 * 1024;

            $file = self::$file;

            // if max file size
            if ($file['size'] > $uploadMaxSize) {
                return [
                    'status' => false,
                    'message' => "File size is too large",
                ];
            }


            if (self::$file['error'] == 0) {
                if (in_array(self::$file['type'], self::$notAlowedTypes)) {
                    throw new \Exception("Dosya türüne izin verilmiyor.");
                }
                $fileType = self::fileTypeDetect();


                if ($fileType == "image") {
                    return self::uploadImage();
                } elseif ($fileType == "audio") {
                    return self::uploadAudio();
                } elseif ($fileType == "video") {
                    return self::uploadVideo();
                } else {
                    return self::uploadFile();
                }


//                $uploadPath = __DIR__ . "/../uploads/" . $uploadDir;
//
//
//                if (move_uploaded_file($fileTmpName, $uploadPath . "/original/" . $newFileName)) {
//                    return [
//                        'status' => true,
//                        'message' => "Dosya başarıyla yüklendi.",
//                        'data' => [
//                            'fileType' => $fileType,
//                            'fileSize' => $fileSize,
//                            'fileName' => $fileName,
//                            'fileExtension' => $fileExtension,
//                            'uploadDir' => $uploadDir,
//                            'newFileName' => $newFileName,
//                            'uploadPaths' => $uploadPaths
//                        ]
//                    ];
//                } else {
//                    throw new \Exception("Dosya yüklenemedi.");
//                }
            } else {
                throw new \Exception("Dosya yüklenemedi.");
            }


        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

}


?>
