<?php

namespace Core;

class Schema
{
    public $name;
    public $apiName;
    public $displayName;
    public $modelName;
    public $middlewareName;
    public $controllerName;
    public $schemaName;
    public $slug;
    public $tableName;
    public $fields;
    public $relations;

    public $fieldTypes = [
        'text' => ['type' => 'varchar', 'length' => 255, 'form_type' => 'text', 'form_label' => 'Text', 'form_pattern' => null,],
        'textarea' => ['type' => 'text', 'length' => 65.535, 'form_type' => 'textarea', 'form_label' => 'Textarea', 'form_pattern' => null,],
        'int' => ['type' => 'int', 'length' => 11, 'form_type' => 'number', 'form_label' => 'Number Int', 'form_pattern' => '/^[0-9]*/',],
        'float' => ['type' => 'float', 'length' => 11, 'form_type' => 'number', 'form_label' => 'Number Float', 'form_pattern' => '/[\-\+]?[0-9]*(\.[0-9]+)?/',],
        'decimal' => ['type' => 'decimal', 'length' => 11, 'form_type' => 'number', 'form_label' => 'Number Decimal', 'form_pattern' => '/(?<![\d.])(\d{1,2}|\d{0,2}\.\d{1,2})?(?![\d.])/',],
        'password' => ['type' => 'varchar', 'length' => 255, 'form_type' => 'password', 'form_label' => 'Password', 'form_pattern' => null,],
        'email' => ['type' => 'varchar', 'length' => 255, 'form_type' => 'email', 'form_label' => 'Email', 'form_pattern' => '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+/',],
        'date' => ['type' => 'date', 'length' => null, 'form_type' => 'date', 'form_label' => 'Date', 'form_pattern' => null,],
        'year' => ['type' => 'year', 'length' => 4, 'form_type' => 'number', 'form_label' => 'Year', 'form_pattern' => null,],
        'time' => ['type' => 'time', 'length' => null, 'form_type' => 'time', 'form_label' => 'Time', 'form_pattern' => null,],
        'datetime' => ['type' => 'datetime', 'length' => null, 'form_type' => 'datetime-local', 'form_label' => 'Datetime', 'form_pattern' => null,],
        'boolean' => ['type' => 'tinyint', 'length' => 1, 'form_type' => 'checkbox', 'form_label' => 'Boolean', 'form_pattern' => null,],
        'enum' => ['type' => 'enum', 'length' => null, 'form_type' => 'select', 'form_label' => 'Enum', 'form_pattern' => null,], // values
    ];


    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->tableName}` (";
        foreach ($this->fields as $field) {
            $sql .= "`{$field['name']}` {$field['type']}";

            if ($field['type'] == 'enum') {
                $sql .= "('" . implode("','", $field['values']) . "')";
            }

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
                $sql .= $field['nullable'] || isset($field['default']) ? " NULL" : " NOT NULL";
            }

            if (isset($field['unique']) && $field['unique']) {
                $sql .= " UNIQUE";
            }
            if (isset($field['default']) && $field['default']) {
                $sql .= is_string($field['default']) && $field['default'] !== "CURRENT_TIMESTAMP" && $field['default'] !== "CURRENT_TIMESTAMP" ?
                    " DEFAULT '{$field['default']}'" :
                    " DEFAULT {$field['default']}";
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

            // relations
            $relations = [];
            foreach ($this->relations as $relation) {
                $relations[] = $relation['name'];
            }
            $relations = implode("', '", $relations);
            $template = str_replace("[relations]", "'$relations'", $template);



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

    public function createMiddleware()
    {
        try {

            $templateFile = __DIR__ . "/../utilities/templates/middleware.template.txt";
            $template = file_get_contents($templateFile);

            $template = str_replace("[class_name]", $this->middlewareName, $template);


            $filePath = __DIR__ . "/../App/Middlewares/API/";
            $fileName = $this->middlewareName . ".php";

            $file = fopen($filePath . $fileName, "w");
            fwrite($file, $template);
            fclose($file);

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function createController()
    {
        try {
            $templateFile = __DIR__ . "/../utilities/templates/controller.template.txt";
            $template = file_get_contents($templateFile);

            $template = str_replace("[class_name]", $this->controllerName, $template);
            $template = str_replace("[model_name]", $this->modelName, $template);
            $template = str_replace("[schema_name]", $this->schemaName, $template);

            $filePath = __DIR__ . "/../App/Controllers/API/";
            $fileName = $this->controllerName . ".php";

            $file = fopen($filePath . $fileName, "w");
            fwrite($file, $template);
            fclose($file);

            return true;


        } catch (\Exception $e) {
            return false;
        }
    }


    public function createRouteFile()
    {
        try {

            $templateFile = __DIR__ . "/../utilities/templates/route.template.txt";
            $template = file_get_contents($templateFile);

            $template = str_replace("[controller_name]", $this->controllerName, $template);
            $template = str_replace("[middleware_name]", $this->middlewareName, $template);
            $template = str_replace("[api_name]", $this->apiName, $template);

            $filePath = __DIR__ . "/../App/Routes/API/";
            $fileName = $this->displayName . ".route.php";

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
