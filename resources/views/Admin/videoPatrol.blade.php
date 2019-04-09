<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="{{asset('VideoResource/js/jquery.min.js')}}"></script>
    <title>userPatrol</title>
    <script>
        //页面加载   获取全部信息
        $(function () {
            $.ajax({
                type: "GET",//请求方式
                url: "./admin/video/getAllVideos",//地址，就是json文件的请求路径
                dataType: "json",//数据类型可以为 text xml json  script  jsonp
                success: function (result) {//返回的参数就是 action里面所有的有get和set方法的参数
                    addBox(result);
                }
            });
            /*$.get("item.json",function(result){
                //result数据添加到box容器中;
                addBox(result);
            });*/
        });

        function addBox(result) {
            //result是一个集合,所以需要先遍历
            if (result == '未登录') {
                alert('未登录');
            } else {
                $.each(result, function (index, obj) {
                    $("#table1").append(
                        "<tr><td>" +
                        obj['id'] + "</td><td>" +
                        obj['video_name'] + "</td><td>" +//获得用户名
                        obj['video_url'] + "</td><td>" +//获得email
                        obj['from_userid'] + "</td><td>" + //获得token(是否为管理员)
                        obj['created_at'] +//创建时间
                        "</td></tr>");
                });
            }

        }


    </script>
</head>
<body>
<h1><a href="admin">返回管理页面</a></h1>
<h1>All</h1>
<div id="box">
    <table border="1" id='table1'>
        <tr>
            <td>video_id</td>
            <td>video_name</td>
            <td>video_url</td>
            <td>from_userid</td>
            <td>created_at</td>
        </tr>
    </table>
    <table>

        <tr>
            <h1>Search</h1>
            <td>user_id</td>
            <td>user_name</td>
            <td>video_id</td>
            <td>video_name</td>
        </tr>
        <tr>
            <td><input type="text" name="user_id" id="user_id"/></td>
            <td><input type="text" name="user_name" id="user_name"/></td>
            <td><input type="text" name="video_id" id="video_id"/></td>
            <td><input type="text" name="video_name" id="video_name"/></td>
        </tr>
        <tr>
            <td><input type="button" class="btn btn-primary" value="findVideoByUserId" id="findVideoByUserId"/></td>
            <td><input type="button" class="btn btn-primary" value="findVideoByUserName" id="findVideoByUserName"/></td>
            <td><input type="button" class="btn btn-primary" value="findVideoByVideoId" id="findVideoByVideoId"/></td>
            <td><input type="button" class="btn btn-primary" value="findVideoByVideoName" id="findVideoByVideoName"/>
            </td>
        </tr>
    </table>

    <table border="1" id='table2'>
        <tr>
            <td>video_id</td>
            <td>video_name</td>
            <td>video_url</td>
            <td>from_userid</td>
            <td>created_at</td>
        </tr>
     <table>
    <br>
    <h1>Delete</h1>
    <h5>video_id:</h5>
    <input type="text" name="id" id="id"/></td>
    <input type="button" class="btn btn-primary" value="deleteVideoById" id="deleteVideoById"/>
    <br>

    <h1>Update</h1>
    <table>
        <tr>
            <td>video_id</td>
            <td>new_video_name</td>
        </tr>
        <tr>
            <td><input type="text" name="update_video_id" id="update_video_id"/></td>
            <td><input type="text" name="new_video_name" id="new_video_name"/></td>
        </tr>
    </table>


    <input type="button" class="btn btn-primary" value="updateVideoNameById" id="updateVideoNameById"/>

</div>
<script type="text/javascript" src="{{asset('VideoResource/js/jquery.min.js')}}">

</script>
<script type="text/javascript">
    //,清空表中的数据
    function remove() {
        var table = document.getElementById("table2"),
            trs = table.getElementsByTagName("tr");
        for(var i = trs.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
    }
    //删除video
    $(function () {
        $("#deleteVideoById").on("click", function () {
            $.post("./admin/video/deleteVideoById", {
                "_token": '{{csrf_token()}}',
                "id": document.getElementById("id").value
            }, function (data) {
                alert(data);
                window.location.reload();
            });
        });
    });
    //根据 上传用户id 查找视频
    $(function () {
        $("#findVideoByUserId").on("click", function () {
            $.post("./admin/video/findVideoByUserId", {
                "_token": '{{csrf_token()}}',
                "user_id": document.getElementById("user_id").value
            }, function (data) {
                remove();
                $.each(data, function (index, obj) {
                    $("#table2").append(
                        "<tr><td>" +
                        obj['id'] + "</td><td>" +
                        obj['video_name'] + "</td><td>" +//获得用户名
                        obj['video_url'] + "</td><td>" +//获得email
                        obj['from_userid'] + "</td><td>" + //获得token(是否为管理员)
                        obj['created_at'] +//创建时间
                        "</td></tr>");
                });
            });
        });
    });
    //根据 上传用户name 查找视频
    $(function () {
        $("#findVideoByUserName").on("click", function () {
            $.post("./admin/video/findVideoByUserName", {
                "_token": '{{csrf_token()}}',
                "user_name": document.getElementById("user_name").value
            }, function (data) {
                remove();
                $.each(data, function (index, obj) {
                    $("#table2").append(
                        "<tr><td>" +
                        obj['id'] + "</td><td>" +
                        obj['video_name'] + "</td><td>" +//获得用户名
                        obj['video_url'] + "</td><td>" +//获得email
                        obj['from_userid'] + "</td><td>" + //获得token(是否为管理员)
                        obj['created_at'] +//创建时间
                        "</td></tr>");
                });
            });
        });
    });
    //根据 视频id 查找视频
    $(function () {
        $("#findVideoByVideoId").on("click", function () {
            $.post("./admin/video/findVideoByVideoId", {
                "_token": '{{csrf_token()}}',
                "video_id": document.getElementById("video_id").value
            }, function (data) {
                remove();
                $.each(data, function (index, obj) {
                    $("#table2").append(
                        "<tr><td>" +
                        obj['id'] + "</td><td>" +
                        obj['video_name'] + "</td><td>" +//获得用户名
                        obj['video_url'] + "</td><td>" +//获得email
                        obj['from_userid'] + "</td><td>" + //获得token(是否为管理员)
                        obj['created_at'] +//创建时间
                        "</td></tr>");
                });
            });
        });
    });
    //根据 视频name 查找视频
    $(function () {
        $("#findVideoByVideoName").on("click", function () {
            $.post("./admin/video/findVideoByVideoName", {
                "_token": '{{csrf_token()}}',
                "video_name": document.getElementById("video_name").value
            }, function (data) {
                remove();
                $.each(data, function (index, obj) {
                    $("#table2").append(
                        "<tr><td>" +
                        obj['id'] + "</td><td>" +
                        obj['video_name'] + "</td><td>" +//获得用户名
                        obj['video_url'] + "</td><td>" +//获得email
                        obj['from_userid'] + "</td><td>" + //获得token(是否为管理员)
                        obj['created_at'] +//创建时间
                        "</td></tr>");
                });
            });
        });
    });
    //更新视频名称by 视频id
    $(function () {
        $("#updateVideoNameById").on("click", function () {

            $.ajax({
                type: 'POST',
                url: './admin/video/updateVideoNameById',
                data: {
                    "_token": '{{csrf_token()}}',
                    "update_video_id": document.getElementById("update_video_id").value,
                    "new_video_name": document.getElementById("new_video_name").value
                },
                dataType: 'json',
                success: function (data) {
                    alert(data);
                    window.location.reload();
                },
                error: function (data) {
                    alert("error");
                }
            });

        });
    });


</script>
</body>
</html>
