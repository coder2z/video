<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2019/3/7
 * Time: 20:56
 */

namespace App\Http\Controllers\TestController;


use App\Http\Controllers\Controller;
use App\VideoModel\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Test extends Controller
{

    public function test(){

        $data = DB::select("SELECT a.id,a.video_name,a.created_at,b.name from video_info a LEFT JOIN users b on a.from_userid = b.id ;");
        $num = DB::select("SELECT a.id,a.title,a.created_at,b.name from notice a LEFT JOIN users b on a.`from` = b.id;");
        $c = DB::select("SELECT video_info.id,video_name,COUNT(*) as num FROM video_info JOIN collection  ON(video_info.id = collection.video_id ) GROUP BY video_id");
//        return view('VideoSystem.home', compact('data', 'num', 'c'));

        dd($c);


    }

}