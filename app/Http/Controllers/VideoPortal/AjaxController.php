<?php

namespace App\Http\Controllers\VideoPortal;

use App\Http\Controllers\Controller;
use App\VideoModel\Video_info;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function index(){
        $upload = Video_info::where('from_userid','=',Auth::id())->get();

        $collection = DB::table('video_info')
                        ->join('collection',function($join){
                            $join->on('video_id','=','video_info.id')
                                 ->where('user_id','=',Auth::id());
                        })->get();

        $uploadAndCollection = [$upload,$collection];
        return response($uploadAndCollection);
    }
}
