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
                url: "./admin/user/getAllUsers",//地址，就是json文件的请求路径
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
                        obj['name'] + "</td><td>" +//获得用户名
                        obj['email'] + "</td><td>" +//获得email
                        //  obj['token']+"</td><td>"+ //获得token(是否为管理员)
                        obj['created_at'] +//创建时间
                        "</td></tr>");
                });
            }

        }


    </script>
</head>
<body>
<h1><a href="admin">返回管理页面</a></h1>
<div id="box">
    <table border="1" id='table1'>
        <tr>
            <td>id</td>
            <td>name</td>
            <td>email</td>
            <td>created_at</td>
        </tr>
    </table>
    <table>


        <tr>
            <td>id</td>
            <td>name</td>
            <td>email</td>
            <td>password</td>
        </tr>
        <tr>
            <td><input type="text" name="id" id="id"/></td>
            <td><input type="text" name="name" id="name"/></td>
            <td><input type="text" name="email" id="email"/></td>
            <td><input type="text" name="password" id="password"/></td>
            {{--<td><input type="text" name="token" id="token" /></td>--}}
        </tr>

    </table>
    <br>
    <input type="button" class="btn btn-primary" value="insertUser" id="insertUser"/>
    <input type="button" class="btn btn-primary" value="deleteUserById" id="deleteUserById"/>
    <input type="button" class="btn btn-primary" value="updateUserByid" id="updateUser"/>
    <input type="button" class="btn btn-primary" value="findUserById" id="findUserById"/>
    <input type="button" class="btn btn-primary" value="findUserByUserName" id="findUserByUserName"/>
    <input type="button" class="btn btn-primary" value="findUserByEmail" id="findUserByEmail"/>


    <table border="1" id='table2'>
        <tr>
            <td>id</td>
            <td>name</td>
            <td>email</td>
            <td>created_at</td>
        </tr>
    </table>
</div>
<script type="text/javascript" src="{{asset('VideoResource/js/jquery.min.js')}}">

</script>
<script type="text/javascript">
    //,清空表中的数据
    function remove() {
        var table = document.getElementById("table2"),
            trs = table.getElementsByTagName("tr");
        for (var i = trs.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
    }

    //创建新用户
    $(function () {
        $("#insertUser").on("click", function () {
            if ($('#name').val() == '' || $('#email').val() == '' || $('#password').val() == '') {
                alert("请输入除ID以外的全部字段");
            } else {
                $.ajax({
                    type: 'POST',
                    url: './admin/user/insertUser',
                    data: {
                        "_token": '{{csrf_token()}}',
                        "name": document.getElementById("name").value,
                        "email": document.getElementById("email").value,
                        "password": document.getElementById("password").value,
                        //  "token":document.getElementById("token").value
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
            }
        });
    });
    //更新用户信息
    $(function () {

        $("#updateUser").on("click", function () {
            if ($("#id").val() == "" || $("#name").val()=="" || $("#email") == "" || $("#password") == "") {
                alert("id，name，email，password不能为空");
            } else {
                $.ajax({
                    type: 'POST',
                    url: './admin/user/updateUser',
                    data: {
                        "_token": '{{csrf_token()}}',
                        "id": document.getElementById("id").value,
                        "name": document.getElementById("name").value,
                        "email": document.getElementById("email").value,
                        "password": document.getElementById("password").value,
                        //   "token":document.getElementById("token").value
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
            }

        });


    });
    //删除用户
    $(function () {
        $("#deleteUserById").on("click", function () {
            $.post("./admin/user/deleteUser", {
                "_token": '{{csrf_token()}}',
                "id": document.getElementById("id").value
            }, function (data) {
                if (data == '请输入ID') {
                    alert(data);
                } else {
                    alert(data);
                    window.location.reload();
                }


            });
        });
    });

    //根据不同信息查找用户
    $(function () {
        $("#findUserById").on("click", function () {
            if ($("#id").val() == "") {
                alert("请输入id");
            } else {
                $.post("./admin/user/findUserById", {
                    "_token": '{{csrf_token()}}',
                    "id": document.getElementById("id").value
                }, function (data) {
                    //result是一个集合,所以需要先遍历
                    if (data == '未登录') {
                        alert('未登录');
                    } else {
                        //  $.each(data,function(index,obj){
                        remove();
                        var data = JSON.parse(data);
                        $("#table2").append(
                            "<tr><td>" +
                            data.id + "</td><td>" +
                            data.name + "</td><td>" +//获得用户名
                            data.email + "</td><td>" +//获得email
                            //  data.token+"</td><td>"+ //获得token(是否为管理员)
                            data.created_at +//创建时间
                            "</td></tr>");
                        //    });
                    }


                });
            }

        });
    });
    $(function () {
        $("#findUserByUserName").on("click", function () {
            if ($("#name").val()=="") {
                alert("请输入name")
            } else {
                $.post("./admin/user/findUserByUserName", {
                    "_token": '{{csrf_token()}}',
                    "name": document.getElementById("name").value
                }, function (data) {
                    remove();
                    var data = JSON.parse(data);
                    $("#table2").append(
                        "<tr><td>" +
                        data.id + "</td><td>" +
                        data.name + "</td><td>" +//获得用户名
                        data.email + "</td><td>" +//获得email
                        //  data.token+"</td><td>"+ //获得token(是否为管理员)
                        data.created_at +//创建时间
                        "</td></tr>");
                });
            }

        });
    });
    $(function () {
        $("#findUserByEmail").on("click", function () {
            $.post("./admin/user/findUserByEmail", {
                "_token": '{{csrf_token()}}',
                "email": document.getElementById("email").value
            }, function (data) {
                remove();
                var data = JSON.parse(data);
                $("#table2").append(
                    "<tr><td>" +
                    data.id + "</td><td>" +
                    data.name + "</td><td>" +//获得用户名
                    data.email + "</td><td>" +//获得email
                    //  data.token+"</td><td>"+ //获得token(是否为管理员)
                    data.created_at +//创建时间
                    "</td></tr>");
            });
        });
    });
</script>
</body>
</html>
