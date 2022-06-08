<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'master_rooms';
    protected $guarded = ['id'];

    public function data($param1=null,$param2=null,$param3=null)
    {
        $data = Room::select([
                'id',
                'title',
                'path',
                'desc',
            ]);

        if(is_string($param1) && $param2=="equal" && is_array($param3)){
            $data->whereIn($param1,$param3);
        }else if(is_string($param1) && $param2=="not" && is_array($param3)){
            $data->whereNotIn($param1,$param3);
        }else if(is_string($param1) && is_array($param2) && $param3==null){
            $data->whereIn($param1,$param2);
        }else if(is_array($param1) && $param2==null && $param3==null){
            $data->where($param1);
        }else if($param1!=null && $param2==null && $param3==null){
            $data->where('id','=',$param1);
        }

        return $data;
    }
}
