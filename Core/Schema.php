<?php

namespace Core;

class Schema
{
    public $name;
    public $apiName;
    public $displayName;
    public $modelName;
    public $slug;
    public $tableName;
    public $fields;
    public $relations;

    public $fieldTypes = [
        'text' => ['type' => 'varchar', 'length' => 255, 'form_type' => 'text', 'form_label' => 'Text'],
        'textarea' => ['type' => 'text', 'length' => 65.535, 'form_type' => 'textarea', 'form_label' => 'Textarea'],
        'int' => ['type' => 'int', 'length' => 11, 'form_pattern' => '/^[0-9]*/gm', 'form_type' => 'number', 'form_label' => 'Number Int'],
        'float' => ['type' => 'float', 'length' => 11, 'form_pattern' => '/[\-\+]?[0-9]*(\.[0-9]+)?/gm', 'form_type' => 'number', 'form_label' => 'Number Float'],
        'decimal' => ['type' => 'decimal', 'length' => 11, 'form_pattern' => '/(?<![\d.])(\d{1,2}|\d{0,2}\.\d{1,2})?(?![\d.])/gm', 'form_type' => 'number', 'form_label' => 'Number Decimal'],
        'password' => ['type' => 'varchar', 'length' => 255, 'form_type' => 'password', 'form_label' => 'Password'],
        'email' => ['type' => 'varchar', 'length' => 255, 'form_pattern' => '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/gm', 'form_type' => 'email', 'form_label' => 'Email'],
        'date' => ['type' => 'datetime', 'length' => null, 'form_type' => 'date', 'form_label' => 'Date'],
        'boolean' => ['type' => 'tinyint', 'length' => 1, 'form_type' => 'checkbox', 'form_label' => 'Boolean'],
    ];


    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->tableName}` (";
        foreach ($this->fields as $field) {
            $sql .= "`{$field['name']}` {$field['type']}";
            if (isset($field['length']) && $field['length']) {
                $sql .= "({$field['length']})";
            }
            if (isset($field['primary']) && $field['primary']) {
                $sql .= " PRIMARY KEY";
            }
            if (isset($field['autoIncrement']) && $field['autoIncrement']) {
                $sql .= " AUTO_INCREMENT";
            }
            if (isset($field['nullable'])) {
                $sql .= $field['nullable'] ? " NULL" : " NOT NULL";
            }

            if (isset($field['unique']) && $field['unique']) {
                $sql .= " UNIQUE";
            }
            if (isset($field['default']) && $field['default']) {
                $sql .= " DEFAULT {$field['default']}";
            }

            if (isset($field['on_update']) && $field['on_update']) {
                $sql .= " ON UPDATE {$field['on_update']}";
            }

            if (isset($field['index']) && $field['index']) {
                $sql .= " INDEX";
            }
            $sql .= ",";
        }
        $sql = rtrim($sql, ',');
        $sql .= ", PRIMARY KEY(`id`)  ) CHARSET = utf8 AUTO_INCREMENT = 1;";
        return $sql;
    }


    public function createModel()
    {
        try {



            $templateFile = __DIR__ . "/../utilities/templates/model.template.txt";
            $template = file_get_contents($templateFile);

            $template = str_replace("[class_name]", $this->displayName, $template);
            $template = str_replace("[table_name]", $this->tableName, $template);

            $ignoreFields = [
                'id',
                'created_at',
                'updated_at',
            ];

            $fields = [];
            foreach ($this->fields as $field) {
                if (!in_array($field['name'], $ignoreFields)) {
                    $fields[] = $field['name'];
                }
            }
            $fields = implode("', '", $fields);



            $template = str_replace("[fields]", "'$fields'", $template);



            // TODO: Relations add

            $filePath = __DIR__ . "/../App/Models/API/";
            $fileName = $this->modelName . ".php";


            $file = fopen($filePath . $fileName, "w");
            fwrite($file, $template);
            fclose($file);

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }


}


?>
