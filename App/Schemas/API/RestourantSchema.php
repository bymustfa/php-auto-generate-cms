<?php

namespace App\Schemas\API;

use Core\Schema;

class RestourantSchema extends Schema
{
    public function __construct()
    {
        $this->name = 'Restourant';
        $this->apiName = 'restourants';
        $this->displayName = 'Restourant';
        $this->modelName = 'RestourantModel';
        $this->slug = 'restourants';
        $this->tableName = 'cms_restourants';

        $this->relations = [];

        $this->fields = [];

        $this->fields['id'] = [
            'name' => 'id',
            'type' => 'int',
            'length' => 11,
            'nullable' => false,
            'autoIncrement' => true,
        ];

        
		$this->fields['name'] = [
			'name' => 'name',
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
			'form_label' => 'Restoran Adı',
		];

		$this->fields['star'] = [
			'name' => 'star',
			'type' => 'int',
			'length' => 11,
			'primary' => false,
			'autoIncrement' => false,
			'nullable' => false,
			'unique' => false,
			'default' => '1',
			'index' => false,
			'editable' => true,
			'form_type' => 'number',
			'form_label' => 'Restouran Puanı',
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
			'form_label' => 'Restouran Açıklaması',
		];


        $this->fields['created_at'] = [
            'name' => 'created_at',
            'type' => 'datetime',
            'length' => null,
            'primary' => false,
            'autoIncrement' => false,
            'unique' => false,
            'default' => "CURRENT_TIMESTAMP",
            'index' => false,
        ];

        $this->fields['updated_at'] = [
            'name' => 'updated_at',
            'type' => 'datetime',
            'length' => null,
            'primary' => false,
            'autoIncrement' => false,
            'unique' => false,
            'default' => "CURRENT_TIMESTAMP",
            'on_update' => "CURRENT_TIMESTAMP",
            'index' => false,
        ];

    }

    public function migrateDatabase()
    {
        try {
            $sql = $this->createTable();
            sql($sql);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function modelFileCreate()
    {
        try {
            return $this->createModel();
        } catch (\Exception $e) {
            return false;
        }
    }
}
