<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>个人中心</title>
    <script src="{{asset('VideoResource/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('VideoResource/js/webuploader.css')}}">

    <script src="{{asset('VideoResource/js/webuploader.js')}}"></script>
    <script src="{{asset('VideoResource/js/video.js')}}"></script>

</head>

<body>
<a href="index">返回首页</a>
<h4>我的上传</h4>
<div class="tag1">
</div>

<h4>我的收藏</h4>
<div class="tag2">
</div>

<div id="uploaderfile" class="wu-example">
    <!--用来存放文件信息-->
    <div id="thelist" class="uploader-list"></div>
    <div class="btns">
        <div id="picker">选择文件</div>
        <button id="ctlBtn" class="btn btn-default">开始上传</button>

    </div>
    <form class="form-horizontal" method="POST" action="{{ url('uploadDatabase') }}">
        {{ csrf_field() }}
        <input type="hidden" name="avatar" value=""/>
        <h1 class="page-header">视频名称</h1>
        <div class="form-horizontal">
            <div class="form-group">
                <div class="col-md-12">
                    <input type="text" name="name" class="form-control" placeholder="输入视频名称"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button class="btn btn-primary btn-block ">确认</button>
            </div>
        </div>
    </form>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "post",
            url: "{{ url('/ajax') }}",
            success: function (data) {
                for (var i = 0; i < data[0].length; i++) {
                    var msg =
                        '<a href="' + "play?id=" + data[0][i].id + '">' + data[0][i].video_name + '</a><br />';
                    $('.tag1').append(msg);
                }
                for (var i = 0; i < data[1].length; i++) {
                    var msg1 =
                        '<a href="' + "play?id=" + data[1][i].video_id + '">' + data[1][i].video_name + '</a><br />';
                    $('.tag2').append(msg1);
                }
            }
        })
    </script>
</div>
</body>