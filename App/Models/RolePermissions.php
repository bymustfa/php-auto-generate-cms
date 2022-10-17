<?php

namespace App\Models;

use Core\Model;

class RolePermissions extends Model
{

    public $timestamps = false;
    protected $table = "role_permissions";
    protected $primaryKey = "id";

    protected $fillable = ['demo'];


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
