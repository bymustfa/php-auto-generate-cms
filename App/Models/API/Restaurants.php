<?php
namespace App\Models\API;
use Core\Model;

class Restaurants extends Model
{
    public $timestamps = false;
    protected $table = "cms_restaurants";
    protected $primaryKey = "id";

    protected $fillable = [ 'name', 'stars', 'address', 'status' ];


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
