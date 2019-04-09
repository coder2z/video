<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>视频播放</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="{{asset('VideoResource/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('VideoResource/js/play.js')}}"></script>
    <script type="text/javascript" src="{{asset('VideoResource/js/ckplayer/ckplayer/ckplayer.js')}}"></script>
</head>
<body>
<a href="index">返回首页</a>
<div class="m">
    <div id="p"><p>loging</p></div>
    <div id="video" style="width: 600px; height: 400px;"></div>
    <a  href="" download="20190305154523579141" id="download">下载视频</a>
    <div id="collection"><button onclick="collection()">收藏视频</button></div>
    <form id="addcomment" onsubmit="return false" >
        <p>评论：<input type="text" name="form" id="form"/></p>
        <input id="but" type="button"  class="btn btn-default" value="确认提交" onclick="addcomment()">{{csrf_field()}}
    </form>
    <div id="comment"></div>
</div>
</body>
</html>
