<?php


namespace App\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\Generator\SchemaCreator;
use Core\Controller;


class ContentManagementController extends Controller
{

    /**
     * @OA\Post(
     *   path="/app/content-manegement/create",
     *   summary="create new content",
     *   tags={"Content Management"},
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

            if (!isset($entityBody['name']) || strlen(trim($entityBody['name'])) === 0) {
                throw new \Exception("Name is required");
            }

            if (hasNumber($entityBody['name'])) {
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
                'middlewareName' => $displayName . "Middleware",
                'controller_name' => $displayName . "Controller",
                'schema_name' => $displayName . "Schema",
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
