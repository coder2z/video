<?php

namespace App\Http\Controllers\VideoPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
//验证是否登陆
    public function isAdminLogin()
    {

        //写入Auth验证即可；
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
        if (!UserController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        return view('Admin.userPatrol');
    }

    //获取所有用户用
    public function getAllUsers()
    {
        if (!UserController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        $users = DB::table('users')->get();
        //不让他看密码和记住登陆的token
        foreach ($users as $user) {
            $user->password = NULL;
            $user->remember_token = NULL;
        }
        return $users;
    }

    //新建一个用户
    public function insertUser(Request $request)
    {
        if (!UserController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        //验证唯一，不唯一显示422错误
        $this->validate($request, [
            'name' => 'unique:users,name'
        ]);
        return json_encode(DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
//            'token' => $request->token,
//            'created_at' => date('Y-m-d h:i:s', time())
        ]));
    }

    //通过id删除用户
    public function deleteUser(Request $request)
    {
        if (!UserController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        if (isset($request->id) && $request->id) {
            if ($request->id == Auth::id()) {
                return '不能刪除自己';
            } else {
                $filePaths = DB::table('video_info')->select('video_url')->where('from_userid', $request->id)->get();
                foreach ($filePaths as $filePath) {
                    Storage::disk('public')->delete(substr($filePath->video_url, 8));
                }
                DB::table('collection')->where('user_id', $request->id)->delete();
                DB::table('comment')->where('user_id', $request->id)->delete();
                DB::table('notice')->where('from', $request->id)->delete();
                DB::table('video_info')->where('from_userid', $request->id)->delete();
                DB::table('users')->where('id', $request->id)->delete();
                return '刪除成功';
            }
        }
        else{
            return '请输入ID';
        }
    }

    //通过id修改用户
    public function updateUser(Request $request)
    {
        if (!UserController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        //验证唯一，不唯一显示422错误
        $this->validate($request, [
            'name' => 'unique:users,name'
        ]);
        return json_encode(DB::table('users')->where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
//            'token' => $request->token,
//            'created_at' => date('Y-m-d h:i:s', time())
        ]));
    }

    //通过id查找用户
    public function findUserById(Request $request)
    {
        if (!UserController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        $user = DB::table('users')->where('id', $request->id)->first();
        if ($user != null) {
            $user->password = NULL;
            $user->remember_token = NULL;
        }
        return json_encode($user);
    }

    //通过userName查找用户
    public function findUserByUserName(Request $request)
    {
        if (!UserController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        $user = DB::table('users')->where('name', $request->name)->first();
        if ($user != null) {
            $user->password = NULL;
            $user->remember_token = NULL;
        }
        return json_encode($user);
    }

    //通过email查找用户
    public function findUserByEmail(Request $request)
    {
        if (!UserController::isAdminLogin()) {
            return view('VideoSystem.token');
        }
        $user = DB::table('users')->where('email', $request->email)->first();
        if ($user != null) {
            $user->password = NULL;
            $user->remember_token = NULL;
        }
        return json_encode($user);
    }
}
