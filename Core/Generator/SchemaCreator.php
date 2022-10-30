<?php

namespace Core\Generator;

use Core\Schema;


class SchemaCreator
{

    private $ignoreFields = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function createSchema($schemaDatas)
    {
        try {

            $fileName = $schemaDatas['displayName'] . "Schema.php";
            $filePath = __DIR__ . "/../../App/Schemas/API/";

            $schema = new Schema();

            $fieldTypes = $schema->fieldTypes;

            $schema->name = $schemaDatas['name'];
            $schema->apiName = $schemaDatas['apiName'];
            $schema->displayName = $schemaDatas['displayName'];
            $schema->slug = $schemaDatas['slug'];
            $schema->tableName = $schemaDatas['tableName'];
            $schema->modelName = $schemaDatas['modelName'];
            $schema->middlewareName = $schemaDatas['middlewareName'];
            $schema->controllerName = $schemaDatas['controller_name'];
            $schema->schemaName = $schemaDatas['schema_name'];


            $schema->fields = [];
            $schema->relations = [];


            if (isset($schemaDatas['relations']) && count($schemaDatas['relations']) > 0) {
                foreach ($schemaDatas['relations'] as $relation) {
                    $schema->relations[] = [
                        'name' => $relation['name'],
                        'type' => $relation['type'],
                        'model' => $relation['model'],
                        'table_name' => $relation['table_name'],
                        'foreign_key' => "id"
                    ];
                }
            }

            if (isset($schemaDatas['fields'])) {
                foreach ($schemaDatas['fields'] as $field) {
                    $columnName = slug($field['name'], "_");
                    $schema->fields[$field['name']] = [
                        'name' => $columnName,
                        'type' => $fieldTypes[$field['type']]['type'],
                        'length' => $fieldTypes[$field['type']]['length'],
                        'primary' => false,
                        'autoIncrement' => false,
                        'nullable' => $field['nullable'] ?? false,
                        'unique' => $field['unique'] ?? false,
                        'default' => $field['default'] ?? null,
                        'index' => false,
                        'editable' => true,
                        'form_type' => $fieldTypes[$field['type']]['form_type'],
                        'form_label' => $field['form_label'] ?? $fieldTypes[$field['type']]['form_label'],
                    ];

                    if ($fieldTypes[$field['type']]['type'] == 'enum') {
                        $schema->fields[$field['name']]['values'] = $field['values'];
                    }
                }
            }

            $schemaFile = $this->createSchemaFile($schema, $filePath . $fileName);

            if (!$schemaFile) {
                throw new \Exception("Schema file could not be created");
            }

            return [
                'status' => true,
                'message' => "Schema file created successfully",
                'data' => [
                    'name' => $schema->name,
                    'api_name' => $schema->apiName,
                    'schema_name' => $schema->schemaName,
                    'model_name' => $schema->modelName,
                    'middleware_name' => $schema->middlewareName,
                    'controller_name' => $schema->controllerName,
                    'display_name' => $schema->displayName,
                    'slug' => $schema->slug,
                    'table_name' => $schema->tableName,
                    'fields' => $schema->fields,
                    'relations' => $schema->relations,
                ]
            ];


        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }

    }


    private function createFields($fields)
    {
        try {
            $contentString = "";

            foreach ($fields as $field) {
                if (!in_array($field['name'], $this->ignoreFields)) {
                    $contentString .= "\r\n\t\t\$this->fields['" . $field['name'] . "'] = [\r\n";
                    foreach (array_keys($field) as $key => $value) {
                        $contentString .= "\t\t\t'" . $value . "' => " .
                            (
                            is_array($field[$value]) ?
                                "['" . implode("','", $field[$value]) . "']" :
                                (
                                is_string($field[$value]) ? "'" . $field[$value] . "'" :
                                    (
                                    is_bool($field[$value]) ? ($field[$value] ? "true" : "false") :
                                        (
                                        is_null($field[$value]) ? "null" : $field[$value]
                                        )
                                    )
                                )
                            )
                            . ",\r\n";
                    }
                    $contentString .= "\t\t];\r\n";
                }
            }

            return $contentString;
        } catch (\Exception $e) {
            return "";
        }

    }

    private function createRelations($relations)
    {
        try {
            $contentString = "\n";
            foreach ($relations as $relation) {
                $contentString .= "\t\t[\n";
                foreach (array_keys($relation) as $key => $value) {
                    $contentString .= "\t\t\t'" . $value . "' => '" . $relation[$value] . "',\r\n";
                }
                $contentString .= "\t\t],\n";
            }

            return $contentString;
        } catch (\Exception $e) {
            return "";
        }

    }


    private function createSchemaFile($schema, $filePath)
    {
        try {
            $templateFile = __DIR__ . "/../../utilities/templates/schema.template.txt";
            $template = file_get_contents($templateFile);

            $fields = $this->createFields($schema->fields);
            $relations = $this->createRelations($schema->relations);

            $template = str_replace("[name]", $schema->name, $template);
            $template = str_replace("[api_name]", $schema->apiName, $template);
            $template = str_replace("[display_name]", $schema->displayName, $template);
            $template = str_replace("[model_name]", $schema->modelName, $template);
            $template = str_replace("[middleware_name]", $schema->middlewareName, $template);
            $template = str_replace("[controller_name]", $schema->controllerName, $template);
            $template = str_replace("[slug]", $schema->slug, $template);
            $template = str_replace("[table_name]", $schema->tableName, $template);
            $template = str_replace("[class_name]", $schema->schemaName, $template);
            $template = str_replace("[schema_name]", $schema->schemaName, $template);


            $template = str_replace("[other_fields]", $fields, $template);
            $template = str_replace("[relations]", $relations, $template);


            $file = fopen($filePath, "w");
            fwrite($file, $template);
            fclose($file);

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }


}
