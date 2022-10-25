<?php

namespace App\Models;

use Core\Model;

class MediaLibraryModel extends Model
{

    public $timestamps = false;
    protected $table = "media_library";
    protected $primaryKey = "id";

    protected $fillable = ['media_guid', 'media_name', 'media_type', 'media_ext', 'media_paths', 'media_size', 'media_status'];


    public static function beginTransaction()
    {
        self::getConnectionResolver()->connection()->beginTransaction();
    }

    public static function commit()
    {
        self::getConnectionResolver()->connection()->commit();
    }

    public static function rollBack()
    {
        self::getConnectionResolver()->connection()->rollBack();
    }
}

?>
