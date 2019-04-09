<?php

namespace App\VideoModel;

use Illuminate\Database\Eloquent\Model;

class Video_info extends Model
{
    //定义模型关联的数据表
    protected $table = 'video_info';
    //定义主键
    protected $primaryKey = 'id';
    //定义禁止操作时间
    public $timestamps = false;
    //设置允许写入的字段
    protected $fillable = ['id','video_name','video_url','form_userid','created_at'];
}
