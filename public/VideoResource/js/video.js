jQuery(function() {
    var $ = jQuery,
        $list = $('#thelist'),
        $btn = $('#ctlBtn'),
        state = 'pending',
        uploader;

    uploader = WebUploader.create({

        //传递值
        formData : { _token: $('meta[name="csrf-token"]').attr('content')},

        // 不压缩image
        resize: false,

        // swf文件路径
        swf: '/js/Uploader.swf',

        // 文件接收服务端。
        server: 'shangchuan',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#picker',

        fileSingleSizeLimit:1024*1024*1024*3,

        accept: {
            title: '视频文件',
            extensions: 'rmvb,rm,asf,divx,mpg,mpeg,mpe,wmv,mkv,vob,mp4',
        },

        timeout:10*60*1000,

        chunked:true,
        chunkSize:20*1024*1024,
        threads:1,
        chunkRetry:2,

    });

    uploader.on("error",function (type){
        if(type == "Q_TYPE_DENIED"){
            alert("视频文件格式错误，仅支持rmvb,rm,asf,divx,mpg,mpeg,mpe,wmv,mkv,vob,mp4");
        }else if(type == "F_EXCEED_SIZE"){
            alert("文件大小不能超过1024M");
        }
    });

    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {

        $list.append('<tr id="'+ file.id +'" class="file-item">'+'<td width="5%" class="file-num">111</td>'+'<td class="file-name">'+ file.name +'</td>'+ '<td width="20%" class="file-size">'+ (file.size/1024/1024).toFixed(1)+'M' +'</td>' +'<td width="20%" class="file-pro">0%</td>'+'<td class="file-status">等待上传</td>'+'<td width="20%" class="file-manage"><a class="stop-btn" href="javascript:;">暂停</a><a class="remove-this" href="javascript:;">取消</a></td>'+'</tr>');

        //暂停上传的文件
        $list.on('click','.stop-btn',function(){
            uploader.stop(true);
        })
        //删除上传的文件
        $list.on('click','.remove-this',function(){
            if ($(this).parents(".file-item").attr('id') == file.id) {
                uploader.removeFile(file);
                $(this).parents(".file-item").remove();
                $.ajax({
                    type: 'POST',
                    url: 'shangchuan/del',
                    dataType: 'json',
                    data: {'filename': file.name},
                    success: function (data) {
                    },
                });
            }
        })
    });

    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        $("td.file-pro").text("");
        var $li = $( '#'+file.id ).find('.file-pro'),
            $percent = $li.find('.file-progress .progress-bar');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<div class="file-progress progress-striped active">' +
                '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                '</div>' +
                '</div>' + '<br/><div class="per">0%</div>').appendTo( $li ).find('.progress-bar');
        }

        $li.siblings('.file-status').text('上传中');
        $li.find('.per').text((percentage * 100).toFixed(2) + '%');

        $percent.css( 'width', percentage * 100 + '%' );
    });

    uploader.on( 'uploadSuccess', function( file,response ) {
        $( '#'+file.id ).find('.file-status').text('已上传');
        $('input[name=avatar]').val(response.path);
    });

    uploader.on( 'uploadError', function( file ) {
        $( '#'+file.id ).find('.file-status').text('上传出错');
    });

    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').fadeOut();
    });

    uploader.on( 'all', function( type ) {
        if ( type === 'startUpload' ) {
            state = 'uploading';
        } else if ( type === 'stopUpload' ) {
            state = 'paused';
        } else if ( type === 'uploadFinished' ) {
            state = 'done';
        }

        if ( state === 'uploading' ) {
            $btn.text('暂停上传');
        } else {
            $btn.text('开始上传');
        }
    });

    $btn.on( 'click', function() {
        if ( state === 'uploading' ) {
            uploader.stop();
        } else {
            uploader.upload();
        }
    });

});

