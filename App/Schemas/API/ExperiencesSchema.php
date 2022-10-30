<?php
namespace App\Schemas\API;

use Core\Schema;

class ExperiencesSchema extends Schema
{
    public function __construct()
    {
        $this->name = 'Experiences';
        $this->apiName = 'experiences';
        $this->displayName = 'Experiences';
        $this->modelName = 'ExperiencesModel';
        $this->middlewareName = 'ExperiencesMiddleware';
        $this->controllerName = 'ExperiencesController';
        $this->schemaName = 'ExperiencesSchema';
        $this->slug = 'experiences';
        $this->tableName = 'cms_experiences';

        $this->relations = [
		[
			'name' => 'user',
			'type' => 'one_to_one',
			'model' => 'UsersModel',
			'table_name' => 'cms_users',
			'foreign_key' => 'id',
		],
];

        $this->fields = [];

        $this->fields['id'] = ['name' => 'id', 'type' => 'int', 'length' => 11, 'nullable' => false, 'autoIncrement' => true, ];

        
		$this->fields['title'] = [
			'name' => 'title',
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
			'form_label' => 'Title',
		];

		$this->fields['description'] = [
			'name' => 'description',
			'type' => 'text',
			'length' => 65.535,
			'primary' => false,
			'autoIncrement' => false,
			'nullable' => false,
			'unique' => false,
			'default' => null,
			'index' => false,
			'editable' => true,
			'form_type' => 'textarea',
			'form_label' => 'Description',
		];

		$this->fields['city_name'] = [
			'name' => 'city_name',
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
			'form_label' => 'City Name',
		];

		$this->fields['entry_date'] = [
			'name' => 'entry_date',
			'type' => 'year',
			'length' => 4,
			'primary' => false,
			'autoIncrement' => false,
			'nullable' => false,
			'unique' => false,
			'default' => null,
			'index' => false,
			'editable' => true,
			'form_type' => 'number',
			'form_label' => 'Entry Date',
		];

		$this->fields['status'] = [
			'name' => 'status',
			'type' => 'enum',
			'length' => null,
			'primary' => false,
			'autoIncrement' => false,
			'nullable' => false,
			'unique' => false,
			'default' => 'old_work',
			'index' => false,
			'editable' => true,
			'form_type' => 'select',
			'form_label' => 'Status',
			'values' => ['old_work','now_work'],
		];

		$this->fields['exit_date'] = [
			'name' => 'exit_date',
			'type' => 'year',
			'length' => 4,
			'primary' => false,
			'autoIncrement' => false,
			'nullable' => true,
			'unique' => false,
			'default' => null,
			'index' => false,
			'editable' => true,
			'form_type' => 'number',
			'form_label' => 'Exit Date',
		];

		$this->fields['company_name'] = [
			'name' => 'company_name',
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
			'form_label' => 'Company Name',
		];

		$this->fields['link'] = [
			'name' => 'link',
			'type' => 'varchar',
			'length' => 255,
			'primary' => false,
			'autoIncrement' => false,
			'nullable' => true,
			'unique' => false,
			'default' => null,
			'index' => false,
			'editable' => true,
			'form_type' => 'text',
			'form_label' => 'Link',
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

