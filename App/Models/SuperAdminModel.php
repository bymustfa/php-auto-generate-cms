<?php
namespace App\Models;
use Core\Model;

class SuperAdminModel extends Model
{
    public $timestamps = false;
    protected $table = "super_admin";
    protected $primaryKey = "id";

    protected $fillable = [ 'superadmin_name', 'superadmin_password', 'superadmin_status' ];


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
