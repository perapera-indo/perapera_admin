<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuujiModuleQuestion extends Model
{
    protected $table = 'suuji_module_questions';
    protected $guarded = ['id'];

    public function data($param1=null,$param2=null,$param3=null)
    {
        $data = SuujiModuleQuestion::select([
            'id',
            'question',
            'image',
            'audio',
            'test',
            'order',
            'time',
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
}
