<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BunpouParticleResult extends Model
{
    protected $table = 'bunpou_particle_result';
    protected $guarded = ['id'];

    public function data($param1=null,$param2=null,$param3=null)
    {
        $data = BunpouParticleResult::select([
            'id',
            'test',
            'member_id',
            'true_answer_count',
            'question_count',
            'false_answer_count',
            'score',
            'answer',
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
