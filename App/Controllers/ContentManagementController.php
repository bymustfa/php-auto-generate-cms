<?php


namespace App\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\Generator\SchemaCreator;
use Core\Controller;

define('API_TAGS', 'Content Management');

class ContentManagementController extends Controller
{

    /**
     * @OA\Post(
     *   path="/app/content-management/create",
     *   summary="Create a new content",
     *   tags={API_TAGS},
     *   @OA\Response(
     *     response=200,
     *     description="Create"
     *   )
     * )
     */
    public function Create(Request $request)
    {
        try {
            $entityBody = dataClear(json_decode($request->getContent(), true));

            if (!isset($entityBody['fields']) && count($entityBody['fields']) == 0) {
                throw new \Exception('Fields are required', Response::HTTP_BAD_REQUEST);
            }

            if (!isset($entityBody['name']) || strlen(trim($entityBody['name'])) === 0) {
                throw new \Exception("Name is required", Response::HTTP_BAD_REQUEST);
            }

            if (hasNumber($entityBody['name'])) {
                throw new \Exception("Title must not contain numbers", Response::HTTP_BAD_REQUEST);
            }


            $name = $entityBody['name'];
            $apiName = slug(toPlural(strtolower($name)), "-");
            $displayName = toCamelCase(toEnglish(strtolower($name)));
            $slug = slug($apiName, "_");
            $tableName = config("DB_PREFIX") . $slug;

            $fields = $entityBody['fields'];

            $relations = [];

            if (isset($entityBody['relations'])) {
                $relations = $entityBody['relations'];
            }


            $schemaCreator = new SchemaCreator();
            $save = $schemaCreator->createSchema([
                'name' => $name,
                'apiName' => $apiName,
                'displayName' => $displayName,
                'modelName' => $displayName . "Model",
                'middlewareName' => $displayName . "Middleware",
                'controller_name' => $displayName . "Controller",
                'schema_name' => $displayName . "Schema",
                'slug' => $slug,
                'tableName' => $tableName,
                'fields' => $fields,
                'relations' => $relations
            ]);


            if ($save['status']) {
                $data = $save['data'];
                $schemaName = $data['schema_name'];
                $class = 'App\\Schemas\\API\\' . $schemaName;
                $schema = new $class();
                $createTable = $schema->migrateDatabase();
                $createModel = $schema->modelFileCreate();
                $createMiddleware = $schema->middlewareFileCreate();
                $createController = $schema->controllerFileCreate();
                $createRoute = $schema->routeFileCreate();

                if (!$createTable) {
                    $data['error']['createTable'] = "Table could not be created";
                }

                if (!$createModel) {
                    $data['error']['createModel'] = "Model could not be created";
                }

                if (!$createMiddleware) {
                    $data['error']['createMiddleware'] = "Middleware could not be created";
                }

                if (!$createController) {
                    $data['error']['createController'] = "Controller could not be created";
                }

                if (!$createRoute) {
                    $data['error']['createRoute'] = "Route could not be created";
                }

                response([
                    'status' => true,
                    'message' => 'Schema Created Successfully',
                    'data' => $data
                ]);

            } else {
                throw new \Exception("Schema Creation Failed", Response::HTTP_INTERNAL_SERVER_ERROR);
            }


        } catch (\Exception $e) {
            $code = $e->getCode() === 0 ? Response::HTTP_INTERNAL_SERVER_ERROR : $e->getCode();
            response([
                'status' => false,
                'message' => $e->getMessage(),
            ], $code);
        }
    }

    private function getSchemaList()
    {
        try {


            $schemaDir = __DIR__ . "/../Schemas/API/";
            $files = scandir($schemaDir, SCANDIR_SORT_ASCENDING);
            $files = array_diff($files, ['.', '..']);

            $schemas = [];

            foreach ($files as $file) {
                $file = $schemaDir . $file;
                if (file_exists($file)) {
                    require_once $file;
                    $class = 'App\\Schemas\\API\\' . pathinfo($file, PATHINFO_FILENAME);
                    $schema = new $class();
                    $vars = get_object_vars($schema);
                    unset($vars['fieldTypes']);
                    $schemas[] = $vars;
                }
            }

            return $schemas;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function GetAll(Request $request)
    {
        try {
            $schemas = $this->getSchemaList();
            response([
                'status' => true,
                'message' => 'Schemas Fetched Successfully',
                'data' => $schemas
            ]);

        } catch (\Exception $e) {
            $code = $e->getCode() === 0 ? 500 : $e->getCode();
            response([
                'status' => false,
                'message' => $e->getMessage(),
            ], $code);
        }
    }


    public function GetOne(Request $request, $name)
    {
        try {
            $schemas = $this->getSchemaList();
            $schema = array_filter($schemas, function ($item) use ($name) {
                return $item['apiName'] === $name || $item['name'] === $name;
            });

            if (count($schema) === 0) {
                throw new \Exception("Schema not found", 404);
            }

            $schema = array_values($schema)[0];

            response([
                'status' => true,
                'message' => 'Schema Fetched Successfully',
                'data' => $schema
            ]);


        } catch (\Exception $e) {
            $code = $e->getCode() === 0 ? 500 : $e->getCode();
            response([
                'status' => false,
                'message' => $e->getMessage(),
            ], $code);
        }
    }

}

?>
