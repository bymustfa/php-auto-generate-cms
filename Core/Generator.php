<?php

namespace Core;

use Core\GeneratorHelpers;

class Generator extends GeneratorHelpers
{
    public function createRoute($tableName, $fileName, $isCMS = true)
    {
        $foldername = "App/Routes/" . ($isCMS ? "CMS/" : "");
        $extension = ".route.php";


        $routeName = slug($tableName);
        $controllerName = ($isCMS ? "CMS." : "") . $fileName . "Controller";
        $route = $this->routeTemplate($routeName, $controllerName);


        if (file_exists($foldername . $fileName . $extension)) {
            unlink($foldername . $fileName . $extension);
        }


        $routeFile = fopen($foldername . $fileName . $extension, "w");
        fwrite($routeFile, $route);
        fclose($routeFile);

        return [
            'routeName' => $routeName,
            'controllerName' => $controllerName,
            "status" => file_exists($foldername . $fileName . $extension) ? true : false
        ];

    }

    public function routeIndex()
    {
        try {
            $dir = "App/Routes/CMS/";
            $files = scandir($dir);
            $template = "";
            foreach ($files as $file) {
                if ($file != "." && $file != ".." && $file != "index.php") {
                    $template .= "
if (file_exists(__DIR__ . '/$file')) {
    require __DIR__ . '/$file';
}
";
                }
            }
            $indexTemplate = "<?php
$app->router->group('/api', function ($router) {
$template
});
?>

";

            $routeFile = fopen("App/Routes/CMS/index.php", "w");
            fwrite($routeFile, $indexTemplate);
            fclose($routeFile);

            return [
                "status" => file_exists("App/Routes/CMS/index.php") ? true : false
            ];
        } catch (\Exception $e) {
            return [
                "status" => false,
                "error" => $e->getMessage()
            ];
        }


    }

    public function createController($fileName, $isCMS = true)
    {
        $folderName = "App/Controllers/" . ($isCMS ? "CMS/" : "");
        $extension = "Controller.php";
        $controller = $this->controllerTemplate($fileName);

        if (file_exists($folderName . $fileName . $extension)) {
            unlink($folderName . $fileName . $extension);
        }

        $controllerFile = fopen($folderName . $fileName . $extension, "w");
        fwrite($controllerFile, $controller);
        fclose($controllerFile);

        return [
            "controllerName" => $fileName . $extension,
            "status" => file_exists($folderName . $fileName . $extension) ? true : false
        ];
    }

    public function createModel($tableName, $className = null, $isCMS = true)
    {
        try {

            $folderName = "App/Models/" . ($isCMS ? "CMS/" : "");
            $extension = ".php";

            $tableSQL = sql("SHOW COLUMNS FROM " . config("DB_PREFIX") . $tableName);
            $tableSQL = json_decode(json_encode($tableSQL), true);


            $tableSQL = array_map(function ($item) {
                return $item["Field"];
            }, $tableSQL);

            $tableSQL = array_filter($tableSQL, function ($item) {
                return $item != "id";
            });

            $tableSQL = array_filter($tableSQL, function ($item) {
                return $item != "created_at";
            });

            $tableSQL = array_filter($tableSQL, function ($item) {
                return $item != "updated_at";
            });

            $tableSQL = array_map(function ($item) {
                return "'" . $item . "'";
            }, $tableSQL);


            $fillableSQL = implode(", ", $tableSQL);
            $fileName = str_replace(" ", "", ucwords(str_replace("_", " ", $className ? $className : $tableName)));


            $model = $this->modelTemplate(config("DB_PREFIX") . $tableName, $fillableSQL, $fileName);


            if (file_exists($folderName . $fileName . $extension)) {
                unlink($folderName . $fileName . $extension);
            }

            $file = fopen($folderName . $fileName . $extension, "w");
            fwrite($file, $model);
            fclose($file);

            return [
                "modelName" => $fileName,
                "fileName" => $fileName . ".php",
                "tableName" => $tableName,
                "status" => file_exists($folderName . $fileName . $extension) ? true : false
            ];
        } catch (\Exception $e) {
            return [
                "status" => false,
                "error" => $e->getMessage()
            ];
        }
    }

    public function createTable($contentName, $schemaColumns)
    {
        try {
            // $contents example
            // $contents = [
            // "name" => [
            //     'type' => 'string',
            //     'default' => null,
            // ],
            // "email" => [
            //     'type' => 'email',
            //     'default' => null,
            // ],
            // "password" => [
            //     'type' => 'password',
            //     'default' => null,
            // ],
            // "status" => [
            //     'type' => 'boolean',
            //     'default' => 1,
            // ],

            $columns = "";
            foreach ($schemaColumns as $key => $value) {
                $default = isset($value['default']) ? $value['default'] : null;
                $type = isset($value['type']) ? $value['type'] : "string";
                $columns .= $this->columnGenerateForSQL($key, $type, $default) . ",";
            }

            $tableName = slug($contentName, "_");
            $tableSQLName = config("DB_PREFIX") . $tableName;
            $createSQL = "CREATE TABLE if NOT EXISTS `$tableSQLName` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
            $columns
            `created_at` timestamp default CURRENT_TIMESTAMP,
            `updated_at` timestamp default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY(`id`)
            ) CHARSET = utf8 AUTO_INCREMENT = 1;";


            sql($createSQL);

            return [
                'status' => true,
                'message' => "Table created successfully",
                'table_name' => $tableName,
                'sql' => $createSQL
            ];
        } catch (\Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }
    }


    public function renameTable($oldTableName, $newTableName, $isCMS = true)
    {
        try {
            $oldTableNamePref = config("DB_PREFIX") . $oldTableName;
            $newTableNamePref = config("DB_PREFIX") . $newTableName;
            $renameSQL = "RENAME TABLE `$oldTableNamePref` TO `$newTableNamePref`";
            sql($renameSQL);

            $modelFolderName = "App/Models/" . ($isCMS ? "CMS/" : "");
            $extension = ".php";

            // find and delete old model file
            $oldModelFile = $modelFolderName . str_replace(" ", "", ucwords(str_replace("_", " ", $oldTableName))) . $extension;
            if (file_exists($oldModelFile)) {
                unlink($oldModelFile);
            }

            // create new model file
            $modelStatus = $this->createModel($newTableName, $newTableName, $isCMS);


            // find and delete old controller file
            $oldControllerFile = "App/Controllers/" . ($isCMS ? "CMS/" : "") . str_replace(" ", "", ucwords(str_replace("_", " ", $oldTableName))) . "Controller.php";
            if (file_exists($oldControllerFile)) {
                unlink($oldControllerFile);
            }


            $controllerFileName = str_replace(" ", "", ucwords(str_replace("_", " ", $newTableName)));

            // create new controller file
            $controllerStatus = $this->createController($controllerFileName, $isCMS);


            // find and delete old router file
            $oldRouterFile = "App/Routes/" . ($isCMS ? "CMS/" : "") . str_replace(" ", "", ucwords(str_replace("_", " ", $oldTableName))) . ".route.php";

            if (file_exists($oldRouterFile)) {
                unlink($oldRouterFile);
            }


            // create new router file
            $routerStatus = $this->createRoute($newTableName, $controllerFileName, $isCMS);

            $routerIndexStatus = $this->routeIndex();

            return [
                'status' => true,
                'message' => "Table renamed successfully",
                'sql' => $renameSQL,
                'modelStatus' => $modelStatus,
                'controllerStatus' => $controllerStatus,
                'routerStatus' => $routerStatus,
                'routerIndexStatus' => $routerIndexStatus
            ];
        } catch (\Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }
    }


    public function createSchema($contentName, $schemaColumns)
    {
        try {
            $schemaFolder = "App/Schemas/";
            $columns = [];
            foreach ($schemaColumns as $key => $value) {
                $default = isset($value['default']) ? $value['default'] : null;
                $type = isset($value['type']) ? $value['type'] : "string";
                $formType = $this->formTypes[$type];
                $min = isset($value['min']) ? $value['min'] : null;
                $max = isset($value['max']) ? $value['max'] : null;

                $columns[] = [
                    'name' => $key,
                    'type' => $type,
                    'form_type' => $formType,
                    'min' => $min,
                    'max' => $max,
                    'default' => $default,
                ];
            }

            $tableName = config("DB_PREFIX") . slug($contentName, "_");
            $controllerName = str_replace(" ", "", ucwords(str_replace("_", " ", $contentName))) . "Controller";
            $modelName = str_replace(" ", "", ucwords(str_replace("_", " ", $contentName)));

            $schemaDatas = [
                'guid' => guid(),
                'display_name' => $contentName,
                'table_name' => $tableName,
                'controller_name' => $controllerName,
                'model_name' => $modelName,
                'route_name' => $contentName,
                'primary_key' => 'id',
                'columns' => $columns
            ];


            // convert json and save json file $schemaFolder
            $schemaFile = $schemaFolder . $contentName . ".json";
            $schemaFileContent = json_encode($schemaDatas, JSON_PRETTY_PRINT);
            file_put_contents($schemaFile, $schemaFileContent);

            return [
                'status' => true,
                'message' => "Schema created successfully",
                'schema_file' => $schemaFile,
                'schema_file_content' => $schemaFileContent
            ];


        } catch (\Exception $e) {
            echo $e->getMessage();
            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    public function updateSchema($oldSchemaName, $newSchemaName, $schemaColumns)
    {
        try {
            // remove old schema file
            $schemaFolder = "App/Schemas/";
            $oldSchemaFile = $schemaFolder . $oldSchemaName . ".json";
            if (file_exists($oldSchemaFile)) {
                unlink($oldSchemaFile);
            }

            $createSchema = $this->createSchema($newSchemaName, $schemaColumns);

            return $createSchema;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }

    }

    public static function getSchemaList()
    {
        try {
            $folderName = "App/Schemas/";

            // just json files
            $files = glob($folderName . "*.json");

            $schemaList = [];
            foreach ($files as $file) {
                $schemaList[] = json_decode(file_get_contents($file), true);
            }


            if ($schemaList && count($schemaList) > 0) {
                return [
                    "status" => true,
                    "message" => "Schema list found",
                    'data' => [
                        'count' => count($schemaList),
                        'list' => $schemaList
                    ]
                ];
            } else {
                return [
                    "status" => true,
                    "message" => "No schema found",
                    'data' => null
                ];
            }

        } catch (\Exception $e) {
            echo $e->getMessage();
            return [
                "status" => false,
                "message" => $e->getMessage(),
                'data' => null
            ];
        }
    }

    function controllerTemplate($modelName)
    {
        $controllerTamplete = file_get_contents("utilities/controllerTemplate.txt");
        $controllerTamplete = str_replace("[ModelName]", $modelName, $controllerTamplete);
        $controllerTamplete = str_replace("[ControllerName]", $modelName . "Controller", $controllerTamplete);
        return $controllerTamplete;

    }

    function routeTemplate($routeName, $controllerName)
    {
        $routeTamplete = file_get_contents("utilities/routeTemplate.txt");
        $routeTamplete = str_replace("[RouteName]", $routeName, $routeTamplete);
        $routeTamplete = str_replace("[ControllerName]", $controllerName, $routeTamplete);
        return $routeTamplete;
    }

    function modelTemplate($tableName, $fillable = "", $className)
    {
        //read file utilities/modelTemplate.txt and replace
        $modelTemplate = file_get_contents("utilities/modelTemplate.txt");
        $modelTemplate = str_replace("[TableName]", $tableName, $modelTemplate);
        $modelTemplate = str_replace("[Fillable]", $fillable, $modelTemplate);
        $modelTemplate = str_replace("[ModelName]", $className, $modelTemplate);

        return $modelTemplate;
    }

}

?>
