<?php

namespace App\Http\Controllers\VideoPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    //根据Auth判断是否登录管理员账号；
    public function isAdminLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->token == 1) {
                return true;
            } else {
                return false;
            }
        }

    }

    //入口网页入口方法
    public function enter()
    {
        if (!AnnouncementController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return view('Admin.noticePatrol');
    }

    //开始显示所有Notice
    public function getAllNotices()
    {
        if (!AnnouncementController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('notice')->get();
    }

    //创建新的公告
    public function insertNotice(Request $request)
    {
        if (!AnnouncementController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return json_encode(DB::table('notice')->insert([
            'title' => $request->title,
            'text' => $request->text,
            'from' => $request->from,
//            'created_at' => date('Y-m-d h:i:s', time())
        ]));
    }

    //根据Notice id删除notice
    public function deleteNoticeByNoticeId(Request $request)
    {
        if (!AnnouncementController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('notice')->where('id', $request->notice_id)->delete();
    }

    //根据Notice title删除notice
    public function deleteNoticeByTitle(Request $request)
    {
        if (!AnnouncementController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('notice')->where('title', $request->notice_title)->delete();
    }

    //根据User id删除notice
    public function deleteNoticeByUserId(Request $request)
    {
        if (!AnnouncementController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('notice')->where('from', $request->notice_from)->delete();
    }

    //根据Notice id查找notice
    public function findNoticeByNoticeId(Request $request)
    {
        if (!AnnouncementController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('notice')->where('id', $request->notice_id)->get();
    }

    //根据Notice title查找notice
    public function findNoticeByNoticeTitle(Request $request)
    {
        if (!AnnouncementController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('notice')->where('title', $request->notice_title)->get();
    }

    //根据User id查找notice
    public function findNoticeByUserId(Request $request)
    {
        if (!AnnouncementController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('notice')->where('from', $request->from_user_id)->get();
    }

    //根据Notice id更新notice
    public function updateNoticeByNoticeId(Request $request)
    {
        if (!AnnouncementController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('notice')->where('id', $request->notice_id)
            ->update([
                'title' => $request->title,
                'text' => $request->text,
                'from' => $request->from
            ]);
    }

    //更具Notice title更新notice
    public function updateNoticeByNoticeTitle(Request $request)
    {
        if (!AnnouncementController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return DB::table('notice')->where('title', $request->notice_title)
            ->update([
                'title' => $request->title,
                'text' => $request->text,
                'from' => $request->from
            ]);
    }

}
