<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/error', function () {
    return view('VideoSystem.token');
});

Route::any('/test', 'TestController\Test@test');
/*
 * 向良峰
 * 2019/3/8
 */
//主页
Route::get('/index', 'VideoPortal\HomeController@showVideo')->name('index');

/*
 * 杨泽秒
 * 杜宇博
 * 2019/3/8
 */

Route::group(['middleware' => 'auth.check'], function () {
    //视频页面
    Route::get('/play', 'VideoPlay\PlayController@play');
    //页面数据交互
    Route::get('/play/video', 'VideoPlay\PlayController@video');
//页面评论交互
    Route::get('/play/comment', 'VideoPlay\PlayController@comment');
//添加评论
    Route::post('/play/addcomment', 'VideoPlay\PlayController@addcomment');
//收藏视频
    Route::get('/play/collection', 'VideoPlay\PlayController@collection');
//收藏判断
    Route::get('/play/collection/verification', 'VideoPlay\PlayController@verification');
//收藏取消
    Route::get('/play/collection/cancel', 'VideoPlay\PlayController@cancel');
//评论删除
    Route::post('/play/comment/del', 'VideoPlay\PlayController@del');
//文件上传
    Route::post('/shangchuan', 'VideoPortal\UserUploadController@upload');
    //删除上传
    Route::any('/shangchuan/del', 'VideoPortal\UserUploadController@del');
    //上传数据
    Route::post('/uploadDatabase', 'VideoPortal\UserUploadController@uploadForm');
    //个人中心
    Route::get('/personalcenter', 'VideoPortal\PersonalCenterController@index');

    Route::post('/ajax', 'VideoPortal\AjaxController@index');

    //给公告页面传值
    Route::any('/notice', 'VideoPortal\HomeController@test');
//公告详情页面
    Route::any('/noticeinfo', function () {
        return view('VideoSystem.noticeinfo');
    });

});

/*
 * 李晨坤
 * 2019/3/11
 */
Route::group(['middleware'=>'auth.checkadmin'],function (){

//进入管理页面
    Route::get('admin',function (){
        return view('Admin.Admin');
    });
    Route::get('enterUserPatrol', 'VideoPortal\UserController@enter');
    Route::get('enterVideoPortal', 'VideoPortal\VideoController@enter');
    Route::get('enterNoticePortal', 'VideoPortal\AnnouncementController@enter');

//超级用户管理内容路由
    Route::prefix('admin')->group(function () {
        //超级用户管理普通用户路由
        Route::prefix('user')->group(function () {
            Route::get('getAllUsers', 'VideoPortal\UserController@getAllUsers');
            Route::post('insertUser', 'VideoPortal\UserController@insertUser');
            Route::post('deleteUser', 'VideoPortal\UserController@deleteUser');
            Route::post('updateUser', 'VideoPortal\UserController@updateUser');
            Route::post('findUserById', 'VideoPortal\UserController@findUserById');
            Route::post('findUserByUserName', 'VideoPortal\UserController@findUserByUserName');
            Route::post('findUserByEmail', 'VideoPortal\UserController@findUserByEmail');
        });
        //超级用户管理视频
        Route::prefix('video')->group(function () {
            Route::get('getAllVideos', 'VideoPortal\VideoController@getAllVideos');
            Route::post('deleteVideoById', 'VideoPortal\VideoController@deleteVideoById');
            Route::post('findVideoByUserId', 'VideoPortal\VideoController@findVideoByUserId');
            Route::post('findVideoByUserName', 'VideoPortal\VideoController@findVideoByUserName');
            Route::post('findVideoByVideoId', 'VideoPortal\VideoController@findVideoByVideoId');
            Route::post('findVideoByVideoName', 'VideoPortal\VideoController@findVideoByVideoName');
            Route::post('updateVideoNameById', 'VideoPortal\VideoController@updateVideoNameById');
        });
        //超级用户管理公告
        Route::prefix('notice')->group(function () {
            Route::get('getAllNotices', 'VideoPortal\AnnouncementController@getAllNotices');
            Route::post('insertNotice', 'VideoPortal\AnnouncementController@insertNotice');
            Route::post('deleteNoticeByNoticeId', 'VideoPortal\AnnouncementController@deleteNoticeByNoticeId');
            Route::post('deleteNoticeByTitle', 'VideoPortal\AnnouncementController@deleteNoticeByTitle');
            Route::post('deleteNoticeByUserId', 'VideoPortal\AnnouncementController@deleteNoticeByUserId');
            Route::post('findNoticeByNoticeId', 'VideoPortal\AnnouncementController@findNoticeByNoticeId');
            Route::post('findNoticeByNoticeTitle', 'VideoPortal\AnnouncementController@findNoticeByNoticeTitle');
            Route::post('findNoticeByUserId', 'VideoPortal\AnnouncementController@findNoticeByUserId');
            Route::post('updateNoticeByNoticeId', 'VideoPortal\AnnouncementController@updateNoticeByNoticeId');
            Route::post('updateNoticeByNoticeTitle', 'VideoPortal\AnnouncementController@updateNoticeByNoticeTitle');
        });

    });

});




