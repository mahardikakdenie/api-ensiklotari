<?php
namespace App\Http\Helpers;
class MethodsHelpers 
{
    public static function order($query, $order)
    {
        if ($order === '-id') {
            $query->orderBy('id',"desc");
        }

        return $query;
    }

    public static function entities($query, $entities)
    {
        if ($entities != null || $entities != '') {
            $entities = str_replace(' ', '', $entities);
            $entities = explode(',', $entities);

            try {
                return $query = $query->with($entities);
            } catch (\Throwable $th) {
                return Json::exception(null, validator()->errors());
            }
        }
    }

    public static function limit($query, $limit)
    {
        if($limit) {
            $query->limit($limit);
        }

        return $query;
    }
}
