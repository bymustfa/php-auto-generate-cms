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
            $schema->modelName = $schemaDatas['displayName'] . "Model";

            $schema->fields = [];
            $schema->relations = [];

            if (isset($schemaDatas['fields'])) {
                foreach ($schemaDatas['fields'] as $field) {
                    $schema->fields[$field['name']] = [
                        'name' => $field['name'],
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
                    'schema_file_name' => $fileName,
                    'schema_name' => $schema->displayName . "Schema",
                    'name' => $schema->name,
                    'display_name' => $schema->displayName,
                    'api_name' => $schema->apiName,
                    'slug' => $schema->slug,
                    'table_name' => $schema->tableName,
                    'fields' => $schema->fields,

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
                            is_string($field[$value]) ? "'" . $field[$value] . "'" :
                                (is_bool($field[$value]) ? ($field[$value] ? "true" : "false") :
                                    (is_null($field[$value]) ? "null" : $field[$value])
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


    private function createSchemaFile($schema, $filePath)
    {
        try {

            $templateFile = __DIR__ . "/../../utilities/templates/schema.template.txt";
            $template = file_get_contents($templateFile);

            $fields = $this->createFields($schema->fields);


            $template = str_replace("[name]", $schema->name, $template);
            $template = str_replace("[api_name]", $schema->apiName, $template);
            $template = str_replace("[display_name]", $schema->displayName, $template);
            $template = str_replace("[model_name]", $schema->modelName, $template);
            $template = str_replace("[slug]", $schema->slug, $template);
            $template = str_replace("[table_name]", $schema->tableName, $template);
            $template = str_replace("[class_name]", $schema->displayName . "Schema", $template);

//            foreach ($fields as $key => $value) {
//                $template = str_replace("[fields]", $value, $template);
//            }


            $template = str_replace("[other_fields]", $fields, $template);
            // TODO: Fix relations
            $template = str_replace("[relations]", "", $template);


            $file = fopen($filePath, "w");
            fwrite($file, $template);
            fclose($file);

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }


}
