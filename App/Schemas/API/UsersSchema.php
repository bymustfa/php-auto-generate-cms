<?php
namespace App\Schemas\API;

use Core\Schema;

class UsersSchema extends Schema
{
    public function __construct()
    {
        $this->name = 'Users';
        $this->apiName = 'users';
        $this->displayName = 'Users';
        $this->modelName = 'UsersModel';
        $this->middlewareName = 'UsersMiddleware';
        $this->controllerName = 'UsersController';
        $this->schemaName = 'UsersSchema';
        $this->slug = 'users';
        $this->tableName = 'cms_users';

        $this->relations = [];

        $this->fields = [];

        $this->fields['id'] = ['name' => 'id', 'type' => 'int', 'length' => 11, 'nullable' => false, 'autoIncrement' => true, ];

        
		$this->fields['name_surname'] = [
			'name' => 'name_surname',
			'type' => 'varchar',
			'length' => 255,
			'primary' => false,
			'autoIncrement' => false,
			'nullable' => false,
			'unique' => false,
			'default' => null,
			'index' => false,
			'editable' => true,
			'form_type' => 'text',
			'form_label' => 'Ad Soyad',
		];

		$this->fields['e_mail'] = [
			'name' => 'e_mail',
			'type' => 'varchar',
			'length' => 255,
			'primary' => false,
			'autoIncrement' => false,
			'nullable' => false,
			'unique' => true,
			'default' => null,
			'index' => false,
			'editable' => true,
			'form_type' => 'email',
			'form_label' => 'E-posta',
		];


        $this->fields['created_at'] = ['name' => 'created_at', 'type' => 'datetime', 'length' => null, 'primary' => false, 'autoIncrement' => false, 'unique' => false, 'default' => "CURRENT_TIMESTAMP", 'index' => false, ];

        $this->fields['updated_at'] = ['name' => 'updated_at', 'type' => 'datetime', 'length' => null, 'primary' => false, 'autoIncrement' => false, 'unique' => false, 'default' => "CURRENT_TIMESTAMP", 'on_update' => "CURRENT_TIMESTAMP", 'index' => false, ];

    }

    public function migrateDatabase()
    {
        try
        {
            $sql = $this->createTable();
            sql($sql);
            return true;
        }
        catch(\Exception $e)
        {
            return false;
        }
    }

    public function modelFileCreate()
    {
        try
        {
            return $this->createModel();
        }
        catch(\Exception $e)
        {
            return false;
        }
    }

    public function middlewareFileCreate()
    {
        try
        {
            return $this->createMiddleware();
        }
        catch(\Exception $e)
        {
            return false;
        }
    }

    public function controllerFileCreate()
    {
        try
        {
            return $this->createController();
        }
        catch(\Exception $e)
        {
            return false;
        }
    }

    public function routeFileCreate()
    {
        try
        {
            return $this->createRouteFile();
        }
        catch(\Exception $e)
        {
            return false;
        }
    }
}

