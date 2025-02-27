<?php
namespace App\Libraries;
use Illuminate\Support\Facades\DB;
//use Illuminate\Container\Attributes\DB;
class General
{
    public static function getEnumValues($table, $column)
    {
        //$type = DB::select(DB::raw ("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type;
        //$type = DB::select(DB::raw ("SELECT column_type FROM information_schema.COLUMNS WHERE table_schema = 'nombre_base_datos' AND TABLE_NAME = 'nombre_tabla' AND column_name = 'nombre_campo_de_tipo_enum';"))[0]->Type;
        $type = "enum('General','Coronel','Capitán')";
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = [];
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            //gettype($enum);
            array_push($enum, $v);
        }
        return $enum;
    }

    public static function generarCodigo($numeroRegistro)
    {
        // Aseguramos que el número de registro sea un entero
        $numeroRegistro = (int) $numeroRegistro;

        // Formateamos el número de registro a tres cifras con ceros a la izquierda
        $numeroFormateado = str_pad($numeroRegistro, 3, '0', STR_PAD_LEFT);

        // Concatenamos "POL" con el número formateado
        $codigoGenerado = 'POL' . $numeroFormateado;

        return $codigoGenerado;
    }


}
