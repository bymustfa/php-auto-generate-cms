<?php

namespace Core;

class GeneratorHelpers
{

    public $columnTypesWithSQL = [
        'string' => 'VARCHAR',
        'slug' => 'VARCHAR',
        'text' => 'TEXT',
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
        'number' => '',
        'boolean' => '',
        'date' => '',
        'email' => '55',
        'password' => '',
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
