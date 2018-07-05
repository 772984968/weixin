<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends TemplateController
{
    protected $model;
    public $config = [
        "title" => '订单管理',
        'index' => 'payment.index',//首页
        //  'create' => 'payment.create',//创建
        'store' => 'payment.store',//创建保存
        'show' => 'payment.show',//查看
        'edit' => 'payment.edit',//编辑
        'update' => 'payment.update',//编辑保存
        //   'delete' => 'payment.destroy',//删除
    ];

    //获取数据
    public function getData($request){
        $model= new Payment();
        $limit=$request->limit??'10';
        $count=$model->count();
        $paginate=$model->paginate($limit);
        $data=$paginate->toArray();
        return  $data=['code'=>0,'msg'=>'','count'=>$count,'data'=>$data['data']];
    }
    public function index(Request $request)
    {
        if ($request->ajax()){

            return response()->json($this->getData($request));
        }


        $data['title'] = $this->getTitle();// 标题
        $data['config'] = $this->config;//获取配置
        return view('admin.template.index', compact('data'));
    }
//表格标题
    function getTitle()
    {
        return [[
            ['type' => 'checkbox'],
            ['field' => 'id', 'title' => 'ID', 'sort' => 'true','width'=>30],
            ['field' => 'name', 'title' => '支付方式','width'=>90],
            ['field' => 'user_id', 'title' => '用户名','templet'=>'#userTpl'],
            ['field' => 'type', 'title' => '支付类型','width'=>100],
            ['field' => 'is_cod', 'title' => '货到付款','width'=>100],
            ['field' => 'is_pay', 'title' => '已支付','width'=>100],
            ['field' => 'amount', 'title' => '支付金额', 'sort' => 'true','width'=>100],
            ['field' => 'created_at', 'title' => '创建时间'],
            ['field' => 'right', 'title' => '数据操作', 'align' => 'center', 'toolbar' => '#barDemo', 'width' => 200]
        ]];

    }
}
