@extends('admin.layouts.admin')
@section('_meta')
    @include('admin.layouts._meta')
    <link href="{{asset('admin/plugins/layui/css/layui.css')}}" rel="stylesheet">
@endsection
@section('title', '后台管理')
@section('content')
    <body>
    <div class="layui-container" layui-bg-gray>

        <div class="ibox-content">
            <div class="panel-body">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="tabs_panels.html#collapseOne">消费记录</a>
                            </h5>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">

                                <form class="layui-form layui-form-pane" action="" method="post">
                                    {{ csrf_field() }}
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">积分</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="brand_id" placeholder="" autocomplete="off"
                                                   class="layui-input" value="" disabled>
                                        </div>
                                        <label class="layui-form-label">余额</label>
                                        <div class="layui-input-inline">
                                            <input type="text" name="brand_id" placeholder="" autocomplete="off"
                                                   class="layui-input" value="" disabled>
                                        </div>
                                    </div>
                                </form>
                                <table class="layui-hide" id="demo" lay-filter="basedemo"></table>
                                <script type="text/html" id="barDemo">
                                    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>
                                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                                    <a class="layui-btn layui-btn-xs layui-btn-danger  layui-btn-mini" lay-event="del">删除</a>
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="tabs_panels.html#collapseTwo">上下级关系</a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <form class="layui-form layui-form-pane" action="" method="post">

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion"
                                   href="tabs_panels.html#collapseThree">个人详细信息</a>
                            </h4>
                        </div>
    <div id="collapseThree" class="panel-collapse collapse">
                            <div class="panel-body">
                                <form class="layui-form layui-form-pane" action="" method="post">
                                    {{ csrf_field() }}

                                </form>

                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion"
                                   href="tabs_panels.html#collapseFour">商品详情</a>
                            </h4>
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse">
                            <div class="panel-body">

                            </div>
                        </div>
                    </div>
                   -->
                </div>
            </div>
        </div>


    </div>
    </body>

@endsection
@section('script')
    @include('admin.layouts._script')
    <script src="{{asset('admin/plugins/layui/layui.all.js')}}"></script>
    <script>
        layui.use(['laydate', 'laypage', 'layer', 'table', 'carousel', 'upload', 'element'], function(){
            var laydate = layui.laydate //日期
                ,laypage = layui.laypage //分页
            layer = layui.layer //弹层
                ,table = layui.table //表格
            //执行一个 table 实例
            table.render({
                elem: '#demo'
                ,cellMinWidth: 60 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
                ,id:'testReload'
                ,url: "{{route('payment.index')}}" //数据接口
                ,page: true //开启分页
                ,cols:@json($data['title'])
                ,even: true

            });
            //监听工具条
            table.on('tool(basedemo)', function(obj){
                var data = obj.data;
                if(obj.event === 'detail'){
                    layer.msg('ID：'+ data.id + ' 的查看操作');

                } else if(obj.event === 'del'){
                    @if(isset($data['config']['delete']))
                    layer.confirm('真的删除么', function(index){
                        //向服务端发送删除指令
                        var   url="{{route($data['config']['delete'],":id")}}".replace(':id',data.id);
                        $.ajax({
                            url:url,
                            type:'DELETE',
                            dataType:'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data:{
                                id:data.id
                            },
                            success:function(data){
                                if(data.code=='200'){
                                    layer.msg(data.msg,{icon:1,time:1*1000},function(){
                                        obj.del();
                                        layer.close(index);
                                    });
                                }else{
                                    layer.msg(data.msg,{icon:5});
                                }
                            },
                            error:function(data){
                                layer.msg('数据发送失败',{icon:5});
                            }
                        });

                    });
                    @endif
                } else if(obj.event === 'edit'){
                            @if(isset($data['config']['edit']))
                    var url="{{route($data['config']['edit'],":id")}}"
                    url=url.replace(':id',data.id);
                    layer_show("编辑",url);
                    //  layer.alert('编辑行：<br>'+ JSON.stringify(data))
                    @endif

                }
            });
            //批量删除
            $('.demoTable2 .layui-btn').on('click', function(){
                var checkStatus = table.checkStatus('testReload')
                    ,data = checkStatus.data;
                if(data!=''){
                    @if(isset($data['config']['delete']))
                    $.ajax({
                        url:"{{route($data['config']['delete'],":id")}}",
                        type:'DELETE',
                        dataType:'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            data:JSON.stringify(data),
                        },
                        success:function(data){
                            if(data.code=='200'){
                                layer.msg(data.msg,{icon:1,time:1*1000},function(){
                                    location.replace(location.href);
                                    layer.close(index);
                                });
                            }else{
                                layer.msg(data.msg,{icon:5});
                            }
                        },
                        error:function(data){
                            layer.msg('数据发送失败',{icon:5});
                        }
                    });
                    @endif
                }
            });

        });
    </script>
    <script>
        layui.use('form', function () {
            var form = layui.form;
            //二级联动
            form.on('select(sheng)', function (data) {
                $.getJSON("{{route('category.getCategory')}}?pid=" + data.value, function (data) {
                    var optionstring = "";
                    $.each(data.data, function (i, item) {
                        optionstring += "<option value=\"" + item.id + "\" >" + item.name + "</option>";
                    });
                    $("select[name='shi']").html('<option value="">不选择</option>' + optionstring);
                    form.render('select'); //这个很重要
                });
            })
            //二级联动
            form.on('select(shi)', function (data) {
                $.getJSON("{{route('category.getCategory')}}?pid=" + data.value, function (data) {
                    var optionstring = "";
                    $.each(data.data, function (i, item) {
                        optionstring += "<option value=\"" + item.id + "\" >" + item.name + "</option>";
                    });
                    $("select[name='qu']").html('<option value="">不选择</option>' + optionstring);
                    form.render('select'); //这个很重要
                });
            })


            //监听提交
            form.on('submit(formDemo)', function (formdata) {
                var url = $('.layui-form').attr('action');
                $.ajax({
                    url: url,
                    type: 'PUT',
                    dataType: 'json',
                    data: formdata.field,
                    success: function (data) {
                        if (data.code == '200') {
                            layer.msg(data.msg, {icon: 1, time: 1 * 1000}, function () {
                                var index = parent.layer.getFrameIndex(window.name);
                                parent.layer.close(index);
                            });
                        } else {
                            layer.msg(data.msg, {icon: 5});
                        }
                    },
                    error: function (data) {
                        layer.msg('数据发送失败', {icon: 5});
                    }
                });
                return false;
            });
        });
    </script>
    <!--时间选择-->
    <script>
        layui.use('laydate', function () {
            var laydate = layui.laydate;
            //执行一个laydate实例
            laydate.render({
                elem: '#datetime', //指定元素
                type: 'datetime'
            });

        });
    </script>
    <script>
        layui.use('upload', function () {
            var $ = layui.jquery
                , upload = layui.upload;

            //普通图片上传
            var uploadInst = upload.render({
                elem: '#upload'
                , url: "{{route('upload')}}"
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , before: function (obj) {
                    //预读本地文件示例，不支持ie8
                    obj.preview(function (index, file, result) {
                        $('#demo1').attr('src', result); //图片链接（base64）
                    });
                }
                , done: function (res) {
                    //如果上传失败
                    if (res.code == 0) {
                        return layer.msg(res.msg);
                    }
                    $('input[name="goods_thumb"]').val(res.src);
                    return layer.msg('上传成功');
                }
                , error: function () {
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function () {
                        uploadInst.upload();
                    });
                }
            });
            //多文件列表示例
            var demoListView = $('#demoList')
                , uploadListIns = upload.render({
                elem: '#testList'
                , url: '{{route('upload')}}'
                , accept: 'file'
                , multiple: true
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, auto: false
                , bindAction: '#testListAction'
                , choose: function (obj) {
                    var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                    //读取本地文件
                    obj.preview(function (index, file, result) {
                        var tr = $(['<tr id="upload-' + index + '">'
                            , '<td>' + file.name + '</td>'
                            , '<td>' + (file.size / 1014).toFixed(1) + 'kb</td>'
                            , '<td>等待上传</td>'
                            , '<td>'
                            , '<button class="layui-btn layui-btn-mini demo-reload layui-hide">重传</button>'
                            , '<button class="layui-btn layui-btn-mini layui-btn-danger demo-delete">删除</button>'
                            , '</td>'
                            , '</tr>'].join(''));

                        //单个重传
                        tr.find('.demo-reload').on('click', function () {
                            obj.upload(index, file);
                        });

                        //删除
                        tr.find('.demo-delete').on('click', function () {

                            //delete files[index]; //删除对应的文件
                            tr.remove();
                            uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                        });

                        demoListView.append(tr);
                    });
                }
                , done: function (res, index, upload) {
                    if (res.code == 1) { //上传成功
                        var tr = demoListView.find('tr#upload-' + index)
                            , tds = tr.children();
                        tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(3).html('<input name="images[]" type="hidden" value=' + res.src + '>'); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload, res);
                }
                , error: function (index, upload, res) {
                    var tr = demoListView.find('tr#upload-' + index)
                        , tds = tr.children();
                    tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>' + res.msg);
                    tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });

        });

    </script>
    <!--图片删除-->
    <script>

        $('.link_delte_btn').click(function () {
            var _id = $(this).data('id');
            var hidden_text = $('input[data-id=' + _id + ']');
            var that = $(this);
            $.ajax({
                url: "{{route('product.delImage')}}",
                type: 'POST',
                dataType: 'json',
                data: {
                    id: _id
                }
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.code == '200') {
                        hidden_text.remove();
                        that.parent().parent().remove();
                        layer.msg('成功删除');
                    } else {
                        layer.msg(data.msg, {icon: 5});
                    }
                },
                error: function (data) {
                    layer.msg('数据发送失败', {icon: 5});
                }
            });

        });


    </script>
@stop

