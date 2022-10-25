<?php
namespace App\Models\API;
use Core\Model;

class RestourantModel extends Model
{
    public $timestamps = false;
    protected $table = "cms_restourants";
    protected $primaryKey = "id";

    protected $fillable = [ 'name', 'star', 'description' ];


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
