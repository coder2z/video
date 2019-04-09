<?php

namespace App\VideoModel;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //定义模型关联的数据表
    protected $table = 'comment';
    //定义主键
    protected $primaryKey = 'id';
    //定义禁止操作时间
    public $timestamps = false;
    //设置允许写入的字段
    protected $fillable = ['id','user_id','video_id','text','created_at'];

    public function user(){
        return $this -> hasOne('App\User','id','user_id');
    }
}
