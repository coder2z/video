<?php

namespace App\Http\Controllers\VideoPortal;


use App\Http\Controllers\Controller;
//引入DB
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function showVideo()
    {

        $data = DB::select("SELECT a.id,a.video_name,a.created_at,b.name from video_info a LEFT JOIN users b on a.from_userid = b.id ;");
        $num = DB::select("SELECT a.id,a.title,a.created_at,b.name from notice a LEFT JOIN users b on a.`from` = b.id;");
        $c = DB::select("SELECT video_info.id,video_name,COUNT(*) as num FROM video_info JOIN collection  ON(video_info.id = collection.video_id ) GROUP BY video_id");
        return view('VideoSystem.home', compact('data', 'num', 'c'));
    }


    public function test(){

        $c =  DB::select("SELECT id,title,text,created_at from notice;");
        return response($c);
    }




}
