<?php

namespace App\Http\Controllers\VideoPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    //验证是否登陆
    public function isAdminLogin()
    {
        //根据Auth判断是否登录管理员账号；
        if (Auth::check()) {
            if (Auth::user()->token == 1) {
                return true;
            } else {
                return false;
            }
        }

    }

    //管理页面
    public function enter()
    {
        if (!VideoController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return view('Admin.videoPatrol');
    }
//增加（上传）视频 使用杜宇博的
//获取所有视频信息
    public function getAllVideos()
    {
        if (!VideoController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('video_info')->get();
    }

//删除视频
    public function deleteVideoById(Request $request)
    {
        if (!VideoController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        $filePath = DB::table('video_info')->select('video_url')->where('id', $request->id)->get();
        Storage::disk('public')->delete(substr($filePath[0]->video_url, 8));
        DB::table('video_info')->where('id', $request->id)->delete();
        return "刪除成功";
    }

    //通过用户id查找 视频
    public function findVideoByUserId(Request $request)
    {
        if (!VideoController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('video_info')->where('from_userid', $request->user_id)->get();
    }

    //通过用户name查找视频
    public function findVideoByUserName(Request $request)
    {
        if (!VideoController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        if (!is_numeric($request->user_name)) {
            $user = DB::table('users')->where('name', $request->user_name)->first();
            return DB::table('video_info')->where('from_userid', $user->id)->get();
        }

    }

    //通过视频id查找视频
    public function findVideoByVideoId(Request $request)
    {
        if (!VideoController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('video_info')->where('id', $request->video_id)->get();
    }

    //通过视频name查找视频
    public function findVideoByVideoName(Request $request)
    {
        if (!VideoController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('video_info')->where('video_name', $request->video_name)->get();
    }

    //通过视频id修改视频名字
    public function updateVideoNameById(Request $request)
    {
        if (!VideoController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('video_info')->where('id', $request->update_video_id)
            ->update(['video_name' => $request->new_video_name]);
    }
}
