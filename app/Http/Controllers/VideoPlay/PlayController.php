<?php

namespace App\Http\Controllers\VideoPlay;

use App\VideoModel\Collection;
use App\VideoModel\Comment;
use App\VideoModel\Video_info;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PlayController extends Controller
{
    //播放页面展示
    public function play(){
        if (is_array($_GET)&&count($_GET)>0){
            if (isset($_GET["id"])&&$_GET["id"]>0){
                return view('VideoSystem.play1');
            }else{
                return view('VideoSystem.token');
            }
        }else{
            return view('VideoSystem.token');
        }
    }
    //页面视频数据
    public function video()
    {
        $id = $_GET['id'];
        if($id>0){
            $db = Video_info::where('id', $id)->get();
            return json_encode($db);
        }
    }

    //收藏视频
    public function collection()
    {
        $videoid = $_GET['id'];
        if ($videoid>0){
            $nameid = Auth::id();
            $result = Collection::insert([
                'user_id' => $nameid,
                'video_id' => $videoid,
            ]);
            return json_encode($result);
        }
    }

    //收藏判断
    public function verification()
    {
        $videoid = $_GET['id'];
        if ($videoid>0){
            $nameid = Auth::id();
            $db = Collection::Where('video_id', $videoid)->Where('user_id', $nameid)->get();
            if ($db->first()) {
                return '1';
            } else {
                return '0';
            }
        }
    }

    //取消收藏
    public function cancel()
    {
        $videoid = $_GET['id'];
        if ($videoid>0){
            $nameid = Auth::id();
            $db = Collection::Where('video_id', $videoid)->Where('user_id', $nameid)->delete();
            return json_encode($db);
        }
    }
    //
    //加载评论
    public function comment()
    {
        $id = $_GET['id'];
        $name = Auth::id();
        if($id>0){
            $token = Auth::user()->token;
            $nameid = [
                'nameid' => $name,
                'token' => $token,
            ];
            $db = Comment::Where('video_id', $id)->orderBy('created_at', 'ASC')->get();
            $orderData = [];
            foreach ($db as $key => $order) {
                $orderData[$key] = $order->toArray();
                $orderData[$key]['username'] = $order->user()->get()->toArray();
                $orderData[$key]['username']['1'] = $nameid;
            }
            return json_encode($orderData);
        }
    }

    //添加评论
    public function addcomment(Request $request){
        $videoid=$_GET['id'];
        if ($videoid>0){
            $nameid =Auth::id();
            $name =Auth::user()->name;
            $result=Comment::insertGetId([
                'video_id'=>$videoid,
                'user_id'=>$nameid,
                'text'=>$request->form,
            ]);
            if ($result){
                $orderData = [
                    'name'=>$name,
                    'id'=>$result
                ];
                return json_encode($orderData);
            }else{
                return '0';
            }
        }
    }


    //评论删除
    public function del(Request $request)
    {
        $commentid = $request->commentid;
        $user_id = Auth::id();
        if(Auth::user()->token==1){
            $result = Comment::Where('id', $commentid)->delete();
        }else{
            $result = Comment::Where('user_id', $user_id)->Where('id', $commentid)->delete();
        }
        return $result ? '1' : '0';
    }
}
