<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BunpouModules extends Model
{
    protected $table = 'bunpou_modules';
    protected $guarded = ['id'];

    public function data($param1=null,$param2=null,$param3=null)
    {
        $data = BunpouModules::select([
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
        return BunpouModules::where("is_active",true)->orderBy("order","asc");
    }

    public function withTestCount(){
        return BunpouModules::
            select(DB::raw("
                (
                    SELECT id FROM bunpou_module_tests
                    WHERE bunpou_module_tests.module = bunpou_modules.id
                    LIMIT 1 OFFSET 0
                ) AS test_count,
                *
            "))
            ->orderBy("order","asc")
            ->get();
    }

    public function withChapterCount(){
        return BunpouModules::
            select(DB::raw("
                (
                    SELECT id FROM bunpou_chapters
                    WHERE bunpou_chapters.module = bunpou_modules.id
                    LIMIT 1 OFFSET 0
                ) AS chapter_count,
                *
            "))
            ->orderBy("order","asc")
            ->get();
    }
}
