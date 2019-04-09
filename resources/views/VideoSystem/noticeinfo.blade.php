
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>公告详情</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('VideoResource/js/jquery.min.js')}}"></script>

</head>
<body>
        <div class="title">
        </div>
        <div class="text">


        </div>
        <div class="notice-time">

        </div>
        <script type="text/javascript">
            //获取地址栏中的name值的函数
            function GetQueryString(name)
            {
                var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
                var r = window.location.search.substr(1).match(reg);
                if(r!=null)return unescape(r[2]); return null;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:"{{url('/notice')}}",
                // dataType:'json',
                success:function(data){
                    // 获取地址栏中id的值
                    var nid = GetQueryString("id");

                        for(var i = 0; i < data.length; i++){

                            if(data[i].id==nid){

                                var title =
                                    '<h1 align="center">'+data[i].title+'</h1>';
                                $('.title').append(title);
                                var text =
                                    '<p style="text-indent: 2em">'+data[i].text+'</p>';
                                $('.text').append(text);
                                var time =
                                    '<p align="right">'+"发布时间:"+'&nbsp'+data[i].created_at+'</p>';
                                $('.notice-time').append(time);

                            }



                        }

                }
            });



        </script>





</body>
</html>



