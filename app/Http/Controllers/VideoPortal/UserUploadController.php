<?php

namespace App\Http\Controllers\VideoPortal;

use App\Http\Controllers\Controller;
use App\VideoModel\Video_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class UserUploadController extends Controller
{
    public function upload()
    {
        $num = Input::get('chunk', 0);
        $count = Input::get('chunks', 0);
        $file = Input::file('file');
        //获取原文件名
        $originalName = $file->getClientOriginalName();
        //扩展名
        $ext = $file->getClientOriginalExtension();
        //文件类型
        $type = $file->getClientMimeType();
        //临时绝对路径
        $realPath = $file->getRealPath();
        if ($num == $count) {
            //直接保存
            $filename = date('Y-m-d-H-i-S') . '-' . uniqid() . '-.' . $ext;
            $bool = Storage::disk('public')->put($filename, file_get_contents($realPath));
            $result = [
                'path' => 'storage/' . $filename,
            ];
        } else {

            //定义储存路径
            $files_names = 1;
            //分片临时文件名
            $filename = md5($originalName) . '-' . ($num + 1) . '.tmp';
            //上传目录
            $path_name = 'storage/' . $filename;
            //保存临时文件
            $bool = Storage::disk('public')->put($filename, file_get_contents($realPath));
            //当分片上传完时 合并
            if (($num + 1) == $count) {
                //最后合成后的名字及路径
                $files_names = 'storage/' . date("Y-m-d-H-i-S", time()) . rand(100000, 999999) . '.' . $ext;
                //打开文件
                $fp = fopen($files_names, "ab");
                //循环读取临时文件，写入最终文件
                for ($i = 0; $i < $count; $i++) {
                    //临时文件路径及名称
                    $tmp_files = 'storage/' . md5($originalName) . '-' . ($i + 1) . '.tmp';
                    //打开临时文件
                    $handle = fopen($tmp_files, "rb");
                    //读取临时文件 写入最终文件
                    fwrite($fp, fread($handle, filesize($tmp_files)));
                    //关闭句柄 不关闭删除文件会出现没有权限
                    fclose($handle);
                    //删除临时文件
                    unlink($tmp_files);
                }
                //关闭句柄
                fclose($fp);
            }
            $result = [
                'path' => $files_names,
            ];
        }
        return response()->json($result);
    }

    public function uploadForm(Request $request)
    {
        if (isset($request->name) && $request->name && isset($request->avatar) && $request->avatar){
            $vider_info = new Video_info();
            $vider_info->video_name = $request->name;
            $vider_info->video_url = $request->avatar;
            $vider_info->from_userid = Auth::id();
            $vider_info->save();
            return redirect('personalcenter');
        }
        return redirect('personalcenter');


    }

    public function del(Request $request)
    {
        $filename = $request->filename;
        $dirname = 'storage';
        $arr = scandir($dirname);
        $php = count(preg_grep("/\.tmp$/", $arr));
        if (!is_dir($dirname)) {
            echo "{$dirname} not effective dir";
            exit();
        }
        $handle = opendir($dirname); //打开目录

        while (($file = readdir($handle)) !== false) //读取目录
        {
            if ($file != "." && $file != '..') {
                if (is_dir($dirname . $file)) {
                    echo $dirname . $file . "<br/>";
                } else {
                    echo "--" . $dirname . "/" . $file . "<br/>";
                    $temp = substr($file, strrpos($file, '.') + 1); //获取后缀格式
                    if ($temp == "tmp") {
                        for ($i = 0; $i < $php; $i++) {
                            $tmp_files = md5($filename) . '-' . ($i + 1) . '.' . 'tmp';
                            if ($tmp_files == $file) {
                                unlink($dirname . '/' . $file);
                            }
                        }
                    }
                }
            }
        }
    }
}
