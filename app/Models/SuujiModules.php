<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SuujiModules extends Model
{
    protected $table = 'suuji_modules';
    protected $guarded = ['id'];

    public function data($param1=null,$param2=null,$param3=null)
    {
        $data = SuujiModules::select([
            'id',
            'name',
            'order',
            'is_active',
        ]);

        if(is_string($param1) && $param2=="equal" && is_array($param3)){
            $data->whereIn($param1,$param3);
        }else if(is_string($param1) && $param2=="not" && is_array($param3)){
            $data->whereNotIn($param1,$param3);
        }else if(is_string($param1) && is_string($param2) && !is_null($param3)){
            $data->where($param1,$param2,$param3);
        }else if(is_string($param1) && !is_null($param2) && is_null($param3)){
            $data->where($param1,$param2);
        }else if(is_string($param1) && is_array($param2) && is_null($param3)){
            $data->whereIn($param1,$param2);
        }else if(is_array($param1) && is_array($param1[array_key_first($param1)]) && is_null($param2) && is_null($param3)){
            $data->where($param1);
        }else if(is_array($param1) && is_null($param2) && is_null($param3)){
            $data->where([$param1]);
        }else if($param1!=null && is_null($param2) && is_null($param3)){
            $data->where('id','=',$param1);
        }

        return $data;
    }

    public function isActive(){
        return SuujiModules::where("is_active",true)->orderBy("order","asc");
    }

    public function withTestCount(){
        return SuujiModules::
            select(DB::raw("
                (
                    SELECT id FROM suuji_module_tests
                    WHERE suuji_module_tests.module = suuji_modules.id
                    LIMIT 1 OFFSET 0
                ) AS test_count,
                *
            "))
            ->orderBy("order","asc")
            ->get();
    }

    public function withChapterCount(){
        return SuujiModules::
            select(DB::raw("
                (
                    SELECT id FROM suuji_chapters
                    WHERE suuji_chapters.module = suujiu_modules.id
                    LIMIT 1 OFFSET 0
                ) AS chapter_count,
                *
            "))
            ->orderBy("order","asc")
            ->get();
    }
}
