<?php

namespace App\Http\Controllers\Admin;

use App\Models\Qrcode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QrcodeController extends BaseController
{
    protected $model;
    public $config=[
        'index'=>'qrcode.index',//首页
        'create'=>'qrcode.create',//创建
        'store'=>'qrcode.store',//创建保存
        'show'=>'qrcode.show',//查看
        'edit'=>'qrcode.edit',//编辑
        'update'=>'qrcode.update',//编辑保存
        'delete'=>'qrcode.destroy',//删除
    ];
    public function __construct()
    {
        $this->model= new Qrcode();

    }
    public function show(Request $request,$goods_id){
        $data['config'] = $this->config;//获取配置
        $qrcode=Qrcode::where('goods_id',$goods_id)->first();
        return view('admin.qrcode.show', compact('data','qrcode','goods_id'));
    }

    public function update(Request $request,$goods_id){
           $goods_logo=$request->input('goods_logo');
        $goods_url=$request->input('goods_url');


        $model=Qrcode::where('goods_id',$goods_id)->first();
        if ($model){

            $image=$this->getQrcodeImg($goods_url,ltrim($goods_logo,'/'));
            $model->image=$image;
            $model->goods_url=$goods_url;
            if ($model->save()){

                return response()->json(['code' => 200, 'msg' => '添加成功']);
            }


        }else{

            $model=$this->model;
            $model->goods_id=$goods_id;
            $model->goods_url=$goods_url;
            $model->image=$this->getQrcodeImg($goods_url,ltrim($goods_logo,'/'));

            if ($model->save()){
                return response()->json(['code' => 200, 'msg' => '添加成功']);

            }


}
        return response()->json(['code' => 400, 'msg' => '添加失败']);

    }
    //
    public function getQrcodeImg($url,$logo=''){
        $fileName='uploads/qrcodes/'.time().'.png';
        //使用QrCode类，生成二维码图片
        //format() 修改二维码图片格式，目前仅支持PNG、SVG 和 EPS三种格式，必须在其他格式化方法前调用
      $rs= \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
            //size() 修改二维码图片尺寸：像素
            ->size(198)
            //margin()二维码边距设置,默认为4
            ->margin(2)
            //容错级别设置 L（7%）、M（15%）、Q（25%）、H（30%），容错级别越高，字节码回复率越大，二维码里能存储的数据越少
            ->errorCorrection("H")
            //merge($filename, $percentage, $absolute)Logo或者头像放到二维码图片中，参数分别为 图片路径，百分比，切换绝对路径
            ->merge($logo, .3, true)
            //指定编码
            ->encoding('UTF-8')
            //generate($text , $filename)$text 二维码数据 $filename 文件名及保存路径
            ->generate($url, $fileName);
     return '/'.$fileName;
    }


}
