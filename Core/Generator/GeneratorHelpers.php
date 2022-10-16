<?php

namespace Core\Generator;

class GeneratorHelpers
{

    public $columnTypesWithSQL = [
        'string' => 'VARCHAR',
        'slug' => 'VARCHAR',
        'text' => 'TEXT',
        'rich-text' => 'TEXT',
        'number' => 'INT',
        'boolean' => 'TINYINT',
        'date' => 'TIMESTAMP',
        'email' => 'VARCHAR',
        'password' => 'TEXT',
    ];

    public $columnTypesWithSQLLength = [
        'string' => '255',
        'slug' => '255',
        'text' => '',
        'rich-text' => '',
        'number' => '',
        'boolean' => '',
        'date' => '',
        'email' => '55',
        'password' => '',
    ];

    public $formTypes = [
        'string' => 'text',
        'slug' => 'text',
        'text' => 'textarea',
        'rich-text' => 'textarea',
        'number' => 'number',
        'boolean' => 'checkbox',
        'date' => 'date',
        'email' => 'email',
        'password' => 'password',
    ];

    public $relationTypes = [
        'one-to-one' => 'hasOne',
        'one-to-many' => 'hasMany',
        'many-to-many' => 'belongsToMany',

        'hasMany' => 'one-to-many',
        'hasOne' => 'one-to-one',
        'belongsToMany' => 'many-to-many',
    ];

    public function columnGenerateForSQL($columnName, $columnType, $default = null, $notNull = false)
    {
        $columnSQLName = slug($columnName, "_");
        $columnSQLType = $this->columnTypesWithSQL[$columnType];
        $columnSQLLength = $this->columnTypesWithSQLLength[$columnType];

        $columnSQL = "`$columnSQLName` $columnSQLType";
        if ($columnSQLLength != "") {
            $columnSQL .= "($columnSQLLength)";
        }
        if ($notNull) {
            $columnSQL .= " NOT NULL";
        } else {
            $columnSQL .= " NULL";
        }
        if ($default != null) {
            $columnSQL .= " DEFAULT '$default'";
        }

        return $columnSQL;


    }

}

?>
