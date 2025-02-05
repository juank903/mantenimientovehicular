<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait HasEnumValues
{
    /**
     * Obtiene los valores de una columna ENUM en cualquier tabla
     *
     * @param string $table Nombre de la tabla
     * @param string $column Nombre de la columna
     * @return array Valores del ENUM
     */
    public static function getEnumValues($table, $column)
    {
        $columnType = DB::selectOne("
            SELECT COLUMN_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = ?
            AND COLUMN_NAME = ?
        ", [$table, $column]);

        if ($columnType) {
            preg_match_all("/'([^']+)'/", $columnType->COLUMN_TYPE, $matches);
            return $matches[1]; // Retorna los valores del ENUM como un array
        }

        return []; // Si no hay valores ENUM, retorna un array vacío
    }
}
