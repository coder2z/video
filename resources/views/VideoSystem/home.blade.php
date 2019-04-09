<!DOCTYPE html>
<html lang="zh-CN">
<head>

    <link href="{{asset('VideoResource/css/bootstrap.min.css')}}" rel="stylesheet">
    {{--<link rel="stylesheet" href="css/app.css" />--}}
    {{--<link rel="stylesheet" href="css/main.css" />--}}
    {{--<script src="http://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>--}}
    {{--<script src="http://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
</head>

{{--登录 退出按钮--}}
<body>
<div class="navbar navbar-default">
    <div class="navbar-collapse collapse">
        <div class="container">
            <ul class="nav navbar-nav navbar-left">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <p>
                        已登录！！！
                    </p>
                <form method="post" action="{{route('logout')}}">
                    @csrf
                    <button type="submit" >注销</button>
                </form>

                @else
                    <p>
                        <a href="{{route('login')}}">登录 </a>
                    </p>
                @endif

            </ul>
        </div>
    </div>
</div>

{{--视频展示表格--}}

<div class="row">
    <div class="col-md-6 offset-md-1">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                {{--<th>Id</th>--}}
                <th class="col-md-1">&nbsp视频名称</th>
                <th class="col-md-1">&nbsp&nbsp作者</th>
                <th class="col-md-1">&nbsp&nbsp&nbsp&nbsp上传时间</th>
                <th class="col-md-1">&nbsp&nbsp&nbsp&nbsp收藏</th>
            </tr>
            </thead>
            <tbody>
            @for($j = 0;$j < count($data);$j++)
                <tr>
                    {{--<td>{{$val->id}}</td>--}}
                    <td class="col-md-1"><a href="play?id={{$data[$j]->id}}">{{$data[$j]->video_name}}</a></td>
                    <td class="col-md-1">{{$data[$j]->name}}</td>
                    <td class="col-md-1">{{$data[$j]->created_at}}</td>
                    <td class="col-md-1">
                        @for($i = 0;$i<count($c);$i++)
                            @if($c[$i]->video_name == $data[$j]->video_name)
                                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{$c[$i]->num}}
                                @break
                            {{--@else--}}
                                {{--&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp0--}}
                                {{--@break--}}
                            @endif


                        @endfor
                    </td>
                </tr>
            @endfor

            </tbody>
        </table>

        {{--公告表格--}}
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                {{--<th>Id</th>--}}
                <th class="col-md-1">&nbsp公告&nbsp</th>
                <th class="col-md-1">&nbsp&nbsp发布者&nbsp&nbsp</th>
                <th class="col-md-1">&nbsp&nbsp&nbsp&nbsp上传时间&nbsp&nbsp&nbsp&nbsp</th>
            </tr>
            </thead>
            <tbody>

            @for($k = 0; $k < count($num);$k++)
                <tr>
                    {{--<td>{{$val->id}}</td>--}}
                    <td class="col-md-1"><a href="noticeinfo?id={{$num[$k]->id}}">{{$num[$k]->title}}</a></td>
                    <td class="col-md-1">{{$num[$k]->name}}</td>
                    <td class="col-md-1">{{$num[$k]->created_at}}</td>
                </tr>
            @endfor
            </tbody>
        </table>

    </div>
</div>

<div>
    <br>
    <br>
    <a href="personalcenter">个人中心-上传视频</a>
    <br>
    <br>
    <br>

    <a href="admin">管理员页面</a>


</div>


</body>


</html>