$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);//search,查询？后面的参数，并匹配正则
    if (r != null) return unescape(r[2]);
    return null;
}

var id = GetQueryString("id");
//页面数据交互-视频
$.ajax({
    type: 'GET',
    url: 'play/video?id=' + id,
    dataType: 'json',
    success: function (data) {
        var videoObject = {
            container: '#video', //容器的ID或className
            variable: 'player',//播放函数名称
            video: [//视频地址列表形式
                [data[0].video_url, 'video/mp4'],
            ]
        };
        var player = new ckplayer(videoObject);
        $('#download').attr('href', data[0].video_url);
        $('#download').attr('download', data[0].video_name);
        $('#p').html("<p>" + data[0].video_name + "</p>")
    },
});
//页面数据交互-评论
$.ajax({
    type: 'GET',
    url: 'play/comment?id=' + id,
    dataType: 'json',
    success: function (data) {
        for (var i = data.length - 1; i >= 0; i--) {
            $('#comment').append("<p id='" + data[i].id + "'>" + data[i].username[0].name + ":" + data[i].text + "  评论时间：" + data[i].created_at);
            if (data[0].username[1].nameid == data[i].user_id || data[0].username[1].token == 1) {
                $('#comment').append("<button id=\"but" + data[i].id + "\" onclick=\"delcomment(" + data[i].id + ")\">删除评论</button>");
            }
        }
    },
});
//判断是否收藏
$.ajax({
    type: 'GET',
    url: 'play/collection/verification?id=' + id,
    dataType: 'json',
    success: function (data) {
        if (data == '1') {
            $('#collection').html("<button onclick=\"cancel()\">取消收藏</button>");
        }
    },
});

//收藏
function collection() {
    $.ajax({
        type: 'GET',
        url: 'play/collection?id=' + id,
        dataType: 'json',
        success: function (data) {
            $('#collection').html("<button onclick=\"cancel()\">取消收藏</button>");
            alert('收藏成功');
        },
    });
}

//删除评论
function delcomment(delid) {
    $.ajax({
        type: 'POST',
        url: 'play/comment/del',
        data: {'commentid': delid},
        dataType: 'json',
        success: function (data) {
            if (data == 1) {
                $('#' + delid + '').html("");
                $('#but' + delid + '').remove();
                alert('删除成功');
            }
        },
    });
}

//取消收藏
function cancel() {
    $.ajax({
        type: 'GET',
        url: 'play/collection/cancel?id=' + id,
        dataType: 'json',
        success: function (data) {
            $('#collection').html("<button onclick=\"collection()\">收藏视频</button>");
        },
    });
}

//添加评论
function addcomment(){
    var str = document.getElementById('form').value.trim();
    if(str.length==0){
        alert('评论不为空！');
        return false;
    }
    Date.prototype.Format = function (fmt) { // author: meizz
        var o = {
            "M+": this.getMonth() + 1, // 月份
            "d+": this.getDate(), // 日
            "h+": this.getHours(), // 小时
            "m+": this.getMinutes(), // 分
            "s+": this.getSeconds(), // 秒
            "q+": Math.floor((this.getMonth() + 3) / 3), // 季度
            "S": this.getMilliseconds() // 毫秒
        };
        if (/(y+)/.test(fmt))
            fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }
    var time2 = new Date().Format("yyyy-MM-dd hh:mm:ss");
    $.ajax({
        type:'POST',
        url:'play/addcomment?id='+id,
        dataType:'json',
        data: $('#addcomment').serialize(),
        success:function(data){
            var html =  $('#comment').html();
            $('#comment').html("<p id=\""+data.id+"\">"+data.name+":"+$('#form').val()+"  评论时间:"+time2+"</p>");
            $('#comment').append("<button id=\"but" + data.id + "\" onclick=\"delcomment(" + data.id + ")\">删除评论</button>"+html);
        },
    });
}
