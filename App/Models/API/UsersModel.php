<?php
namespace App\Models\API;
use Core\Model;

class UsersModel extends Model
{
    public $timestamps = false;
    protected $table = "cms_users";
    protected $primaryKey = "id";

    protected $fillable = [ 'name_surname', 'e_mail' ];


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
