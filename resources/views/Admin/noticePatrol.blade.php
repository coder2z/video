<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>NoticePatrol</title>
    <script type="text/javascript" src="{{asset('VideoResource/js/jquery.min.js')}}"></script>
    <script>
        //页面加载   获取全部信息
        $(function () {
            $.ajax({
                type: "GET",//请求方式
                url: "./admin/notice/getAllNotices",//地址，就是json文件的请求路径
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
                        obj['title'] + "</td><td>" +//获取title
                        obj['text'] + "</td><td>" +//获得text
                        obj['from'] + "</td><td>" + //获得from
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
            <td>notice_id</td>
            <td>notice_title</td>
            <td>notice_text</td>
            <td>from_userid</td>
            <td>created_at</td>
        </tr>
    </table>
    <h1>Insert</h1>
    <table>
        <tr>
            <td>notice_title</td>
            <td>notice_text</td>
            <td>notice_from</td>
        </tr>
        <tr>
            <td><input type="text" name="insertNoticeTitle" id="insertNoticeTitle"/></td>
            <td><input type="text" name="insertNoticeText" id="insertNoticeText"/></td>
            <td><input type="text" name="insertNoticeFrom" id="insertNoticeFrom"/></td>
        </tr>
        <tr>
            <td><input type="button" class="btn btn-primary" value="insertNotice" id="insertNotice"/></td>
        </tr>
    </table>
    <h1>Delete</h1>
    <table>
        <tr>
            <td>deleteNoticeByNoticeId</td>
            <td>deleteNoticeByTitle</td>
            <td>deleteNoticeByUserId</td>
        </tr>
        <tr>
            <td><input type="text" name="deleteNoticeByNoticeId" id="deleteNoticeId"/></td>
            <td><input type="text" name="deleteNoticeByTitle" id="deleteNoticeTitle"/></td>
            <td><input type="text" name="deleteNoticeByUserId" id="deleteNoticeUserId"/></td>
        </tr>
        <tr>
            <td><input type="button" class="btn btn-primary" value="deleteNoticeByNoticeId"
                       id="deleteNoticeByNoticeId"/></td>
            <td><input type="button" class="btn btn-primary" value="deleteNoticeByTitle" id="deleteNoticeByTitle"/></td>
            <td><input type="button" class="btn btn-primary" value="deleteNoticeByUserId" id="deleteNoticeByUserId"/>
            </td>

        </tr>
    </table>
    <h1>Search</h1>
    <table>
        <tr>
            <td>findNoticeByNoticeId</td>
            <td>findNoticeByNoticeTitle</td>
            <td>findNoticeByUserId</td>
        </tr>
        <tr>
            <td><input type="text" name="findNoticeId" id="findNoticeId"/></td>
            <td><input type="text" name="findNoticeTitle" id="findNoticeTitle"/></td>
            <td><input type="text" name="findNoticeUserId" id="findNoticeUserId"/></td>
        </tr>
        <tr>
            <td><input type="button" class="btn btn-primary" value="findNoticeByNoticeId" id="findNoticeByNoticeId"/>
            </td>
            <td><input type="button" class="btn btn-primary" value="findNoticeByNoticeTitle"
                       id="findNoticeByNoticeTitle"/></td>
            <td><input type="button" class="btn btn-primary" value="findNoticeByUserId" id="findNoticeByUserId"/></td>
        </tr>
    </table>
    <table border="1" id='table2'>
        <tr>
            <td>notice_id</td>
            <td>notice_title</td>
            <td>notice_text</td>
            <td>from_userid</td>
            <td>created_at</td>
        </tr>
    </table>
    <h1>Update</h1>
    <table>
        <tr>
            <td>notice_title</td>
            <td>notice_text</td>
            <td>notice_from</td>
        </tr>
        <tr>
            <td><input type="text" name="oldUpdateNoticeTitle" id="newUpdateNoticeTitle"/></td>
            <td><input type="text" name="oldUpdateNoticeText" id="newUpdateNoticeText"/></td>
            <td><input type="text" name="oldUpdateNoticeFrom" id="newUpdateNoticeFrom"/></td>
        </tr>

    </table>
    <br>
    <table>
        <tr>
            <td>updateNoticeByNoticeId</td>
            <td>updateNoticeByTitle</td>
        </tr>
        <tr>
            <td><input type="text" name="updateNoticeId" id="updateNoticeId"/></td>
            <td><input type="text" name="updateNoticeTitle" id="updateNoticeTitle"/></td>
        </tr>
        <tr>
            <td><input type="button" class="btn btn-primary" value="updateNoticeByNoticeId"
                       id="updateNoticeByNoticeId"/></td>
            <td><input type="button" class="btn btn-primary" value="updateNoticeByNoticeTitle"
                       id="updateNoticeByNoticeTitle"/></td>
        </tr>
    </table>


    <script type="text/javascript">
        //,清空表中的数据
        function remove() {
            var table = document.getElementById("table2"),
                trs = table.getElementsByTagName("tr");
            for (var i = trs.length - 1; i > 0; i--) {
                table.deleteRow(i);
            }
        }

        //编辑/更新
        //根据notice id更新
        $(function () {
            $("#updateNoticeByNoticeId").on("click", function () {

                $.ajax({
                    type: 'POST',
                    url: './admin/notice/updateNoticeByNoticeId',
                    data: {
                        "_token": '{{csrf_token()}}',
                        "notice_id": document.getElementById("updateNoticeId").value,
                        "title": document.getElementById("newUpdateNoticeTitle").value,
                        "text": document.getElementById("newUpdateNoticeText").value,
                        "from": document.getElementById("newUpdateNoticeFrom").value
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
        //根据notice title更新
        $(function () {
            $("#updateNoticeByNoticeTitle").on("click", function () {

                $.ajax({
                    type: 'POST',
                    url: './admin/notice/updateNoticeByNoticeTitle',
                    data: {
                        "_token": '{{csrf_token()}}',
                        "notice_title": document.getElementById("updateNoticeTitle").value,
                        "title": document.getElementById("newUpdateNoticeTitle").value,
                        "text": document.getElementById("newUpdateNoticeText").value,
                        "from": document.getElementById("newUpdateNoticeFrom").value
                    },
                    dataType: 'json',
                    success: function (data) {
                        alert(data);
                    },
                    error: function (data) {
                        alert("error");
                    }
                });

            });
        });


        //查找
        //根据notice id查找
        $(function () {
            $("#findNoticeByNoticeId").on("click", function () {
                $.post("./admin/notice/findNoticeByNoticeId", {
                    "_token": '{{csrf_token()}}',
                    "notice_id": document.getElementById("findNoticeId").value
                }, function (data) {
                    remove();
                    $.each(data, function (index, obj) {
                        $("#table2").append(
                            "<tr><td>" +
                            obj['id'] + "</td><td>" +
                            obj['title'] + "</td><td>" +//获取title
                            obj['text'] + "</td><td>" +//获得text
                            obj['from'] + "</td><td>" + //获得from
                            obj['created_at'] +//创建时间
                            "</td></tr>");
                    });
                });
            });
        });
        //根据notice title查找
        $(function () {
            $("#findNoticeByNoticeTitle").on("click", function () {
                $.post("./admin/notice/findNoticeByNoticeTitle", {
                    "_token": '{{csrf_token()}}',
                    "notice_title": document.getElementById("findNoticeTitle").value
                }, function (data) {
                    remove();
                    $.each(data, function (index, obj) {
                        $("#table2").append(
                            "<tr><td>" +
                            obj['id'] + "</td><td>" +
                            obj['title'] + "</td><td>" +//获取title
                            obj['text'] + "</td><td>" +//获得text
                            obj['from'] + "</td><td>" + //获得from
                            obj['created_at'] +//创建时间
                            "</td></tr>");
                    });
                });
            });
        });
        //根据from User id查找
        $(function () {
            $("#findNoticeByUserId").on("click", function () {
                $.post("./admin/notice/findNoticeByUserId", {
                    "_token": '{{csrf_token()}}',
                    "from_user_id": document.getElementById("findNoticeUserId").value
                }, function (data) {
                    remove();
                    $.each(data, function (index, obj) {
                        $("#table2").append(
                            "<tr><td>" +
                            obj['id'] + "</td><td>" +
                            obj['title'] + "</td><td>" +//获取title
                            obj['text'] + "</td><td>" +//获得text
                            obj['from'] + "</td><td>" + //获得from
                            obj['created_at'] +//创建时间
                            "</td></tr>");
                    });
                });
            });
        });


        //删除notice
        //根据Notice id删除
        $(function () {
            $("#deleteNoticeByNoticeId").on("click", function () {
                $.post("./admin/notice/deleteNoticeByNoticeId", {
                    "_token": '{{csrf_token()}}',
                    "notice_id": document.getElementById("deleteNoticeId").value
                }, function (data) {
                    alert(data);
                    window.location.reload();
                });
            });
        });
        //根据notice title删除
        $(function () {
            $("#deleteNoticeByTitle").on("click", function () {
                $.post("./admin/notice/deleteNoticeByTitle", {
                    "_token": '{{csrf_token()}}',
                    "notice_title": document.getElementById("deleteNoticeTitle").value
                }, function (data) {
                    alert(data);
                    window.location.reload();
                });
            });
        });
        //根据User id删除
        $(function () {
            $("#deleteNoticeByUserId").on("click", function () {
                $.post("./admin/notice/deleteNoticeByUserId", {
                    "_token": '{{csrf_token()}}',
                    "notice_from": document.getElementById("deleteNoticeUserId").value
                }, function (data) {
                    alert(data);
                    window.location.reload();
                });
            });
        });


        //insert Notice
        $(function () {
            $("#insertNotice").on("click", function () {

                $.ajax({
                    type: 'POST',
                    url: './admin/notice/insertNotice',
                    data: {
                        "_token": '{{csrf_token()}}',
                        "title": document.getElementById("insertNoticeTitle").value,
                        "text": document.getElementById("insertNoticeText").value,
                        "from": document.getElementById("insertNoticeFrom").value
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
