<?php
namespace App\Helpers;

use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class UtilityHelper
{
    /**
     * @param $tableName 
     * @param $key 
     * @param $value 
     */
    public static function getDropDown($tableName,$key,$value)
    {
        if(!empty($tableName) && !empty($key) && !empty($value)) {
            return DB::table($tableName)->select($key,$value)->get()->toArray();;
        }else{
            return [];
        }
    }
}

