<?php


namespace App\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Core\Generator\SchemaCreator;

use App\Schemas\API;

use Core\Controller;


class ContentManagementController extends Controller
{
    public function Create(Request $request)
    {
        try {

            $entityBody = dataClear(json_decode($request->getContent(), true));

            if (!isset($entityBody['name']) || strlen(trim($entityBody['name'])) === 0) {
                throw new \Exception("Name is required");
            }

            if (hastNumber($entityBody['name'])) {
                throw new \Exception("Title must not contain numbers");
            }

            $name = $entityBody['name'];
            $apiName = slug(toPlural(strtolower($name)), "-");
            $displayName = toCamelCase(toEnglish(strtolower($name)));
            $slug = slug($apiName, "_");
            $tableName = config("DB_PREFIX") . $slug;


            $schemaCreator = new SchemaCreator();
            $save = $schemaCreator->createSchema([
                'name' => $name,
                'apiName' => $apiName,
                'displayName' => $displayName,
                'modelName' => $displayName . "Model",
                'slug' => $slug,
                'tableName' => $tableName,
                'fields' => $entityBody['fields'],
            ]);


            if ($save['status']) {
                $data = $save['data'];
                $schemaName = $data['schema_name'];
                $class = 'App\\Schemas\\API\\' . $schemaName;
                $schema = new $class();
                $createTable = $schema->migrateDatabase();
                $createModel = $schema->modelFileCreate();

                if ($createTable) {
                    response([
                        'status' => true,
                        'message' => 'Schema Created Successfully',
                        'data' => $data
                    ]);
                } else {
                    throw new \Exception("Schema Created Successfully, But Table Creation Failed");
                }

            } else {
                throw new \Exception("Schema Creation Failed");
            }


        } catch (\Exception $e) {
            response([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}

?>
