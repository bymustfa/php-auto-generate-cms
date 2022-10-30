<?php
namespace App\Models\API;
use Core\Model;

class ExperiencesModel extends Model
{
    public $timestamps = false;
    protected $table = "cms_experiences";
    protected $primaryKey = "id";

    protected $fillable = [ 'title', 'description', 'city_name', 'entry_date', 'status', 'exit_date', 'company_name', 'link' ];

     public $relations = [
		[
			'name' => 'user',
			'type' => 'one_to_one',
			'model' => 'UsersModel',
			'table_name' => 'cms_users',
			'foreign_key' => 'id',
			'methodName' => 'user',
		],
];

    
	public function user()
	{
		 return $this->hasOne(UsersModel::class, 'id', 'fk_user_id');
	}




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
