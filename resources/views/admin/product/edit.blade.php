@extends('admin.layouts.admin')
@section('_meta')
    @include('admin.layouts._meta')
    <link href="{{asset('admin/plugins/layui/css/layui.css')}}" rel="stylesheet">
@endsection
@section('title', '后台管理')
@section('content')
    <body>
    <div class="layui-container" layui-bg-gray>
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        </fieldset>
        <form class="layui-form layui-form-pane" action="{{route($config['update'],['id'=>$model->id])}}" method="post">
            {{ csrf_field() }}
            <div class="layui-form-item">
                <label class="layui-form-label">商品名称</label>
                <div class="layui-input-block">
                    <input type="text" autocomplete="off" placeholder="请输入商品名字" class="layui-input" name="goods_name"
                           value="{{$model->goods_name}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">所属品牌</label>
                <div class="layui-input-inline">
                    <input type="text" name="brand_id" placeholder="" autocomplete="off" class="layui-input" value="">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">所属类型{{$category[0]['id']}}</label>
                <div class="layui-input-inline">
                    <select name="sheng" lay-verify="required" lay-filter="sheng">

                        @foreach($node as $node)
                            @if(isset($category[0])&&$node->id==$category[0]['id'])
                                <option selected="selected"
                                        value="{{$category[0]['id']}}">{{$category[0]['name']}}</option>
                            @else
                                <option value="{{$node->id}}">{{$node->name}}</option>
                            @endif
                        @endforeach


                    </select>
                </div>
                <div class="layui-input-inline">
                    <select name="shi" lay-filter="shi">
                        @if(isset($category[1]))
                            <option value="{{$category[1]['id']}}">{{$category[1]['name']}}</option>
                        @endif
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select name="qu">
                        @if(isset($category[2]))
                            <option value="{{$category[2]['id']}}">{{$category[2]['name']}}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">商品库存</label>
                    <div class="layui-input-block">
                        <input type="text" name="goods_number" id="date1" autocomplete="off" class="layui-input"
                               value="{{$model->goods_number}}">
                    </div>
                </div>
                <!--
                <div class="layui-inline">
                    <label class="layui-form-label">商品销量</label>
                    <div class="layui-input-inline">
                        <input type="text" name="sales_sum" autocomplete="off" class="layui-input" value="0">
                    </div>
                </div>
                -->
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">本店价格</label>
                    <div class="layui-input-block">
                        <input type="text" name="shop_price" id="date1" autocomplete="off" class="layui-input"
                               value="{{$model->shop_price}}">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">商场价格</label>
                    <div class="layui-input-inline">
                        <input type="text" name="market_price" autocomplete="off" class="layui-input"
                               value="{{$model->shop_price}}">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">促销价格</label>
                    <div class="layui-input-inline">
                        <input type="text" name="promote_price" autocomplete="off" class="layui-input"
                               value="{{$model->promote_price}}">
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">是否新品</label>
                    <div class="layui-input-inline">
                        <input type="checkbox" @if($model->is_new)checked="" @endif value="1" lay-text="是|否"
                               name="is_new" lay-skin="switch"
                               lay-filter="switchTest" title="开关">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">是否促销</label>
                    <div class="layui-input-inline">
                        <input type="checkbox" @if($model->is_hot)checked="" @endif value="1" lay-text="是|否"
                               name="is_hot" lay-skin="switch"
                               lay-filter="switchTest" title="开关">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">特价促销</label>
                    <div class="layui-input-inline">
                        <input type="checkbox" @if($model->is_promote)checked="" @endif value="1" lay-text="是|否"
                               name="is_promote" lay-skin="switch"
                               lay-filter="switchTest" title="开关">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-inline">
                    <input type="text" name="sort" placeholder="请输入" autocomplete="off" class="layui-input"
                           value="{{$model->sort}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">是否上架</label>
                <div class="layui-input-inline">
                    <input type="checkbox" @if($model->is_on_sale)checked="" @endif value="1" lay-text="是|否"
                           name="is_on_sale" lay-skin="switch"
                           lay-filter="switchTest" title="开关">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">发布时间</label>
                <div class="layui-input-inline">
                    <input name="created_at" type="text" class="layui-input" id="datetime" placeholder="请输入时间"
                           value="{{$model->created_at}}">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">商品略缩图</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" id="upload">上传图片</button>

                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <img class="layui-upload-img" id="demo1" src="{{$model->goods_thumb}}">
                    <input name="goods_thumb" type="hidden" value="">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">商品图片</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-normal" id="testList">选择图片</button>
                    <button type="button" class="layui-btn" id="testListAction">开始上传</button>
                </div>
            </div>
            <div class="layui-upload">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr>
                            <th>文件名</th>
                            <th>大小</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="demoList">
                        @foreach($model->images as $vo)
                            <tr>
                                <td><a href="{{$vo->image}}" target="_blank"><img src="{{$vo->image}}"></a></td>
                                <td></td>
                                <td>正在使用</td>
                                <td>
                                    <button class="layui-btn layui-btn-mini demo-reload layui-hide">重传</button>
                                    <button data-id="{{ $vo->id }}" type="button" class="layui-btn layui-btn-mini layui-btn-danger link_delte_btn">
                                        删除
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">简短描述</label>
                <div class="layui-input-block">
                    <input type="text" name="goods_brief" autocomplete="off" placeholder="请输入商品的简短描述"
                           class="layui-input" value=" this is goods brief">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">商品详细描述</label>
                <div class="layui-input-block">
                    <script id="container" name="goods_desc" type="text/plain" >
                  {!!$model->goods_desc !!}
                    </script>
                 </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>

                </div>
            </div>
        </form>
    </div>
    </body>

@endsection
@section('script')
    @include('admin.layouts._script')
    <script src="{{asset('admin/plugins/layui/layui.all.js')}}"></script>
    <script src="{{asset('admin/plugins/ueditor/ueditor.config.js')}}"></script>
    <script src="{{asset('admin/plugins/ueditor/ueditor.all.js')}}"></script>
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
        var hidden_text = $('input[data-id='+ _id +']');
        var that = $(this);
        $.ajax({
            url: "{{route('product.delImage')}}",
            type: 'POST',
            dataType: 'json',
            data: {
                id:_id
            }
            ,headers: {
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
    <!--百度编辑器 -->
    <script type="text/javascript" >
        var ue = UE.getEditor('container',{
            initialFrameWidth : 1024,
            initialFrameHeight: 500
        });
    </script>
@stop

