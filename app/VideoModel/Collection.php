<?php

namespace App\VideoModel;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    //定义模型关联的数据表
    protected $table = 'collection';
    //定义主键
    protected $primaryKey = 'id';
    //定义禁止操作时间
    public $timestamps = false;
    //设置允许写入的字段
    protected $fillable = ['id','user_id','video_id'];
}
