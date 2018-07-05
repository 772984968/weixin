<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

class UserController extends TemplateController
{
    protected $model;
    public $config=[
        "title"=>'用户管理',
        'index'=>'user.index',//首页
  //      'create'=>'user.create',//创建
        'store'=>'user.store',//创建保存
        'edit'=>'user.edit',//编辑
        'show'=>'user.show',//编辑
        'update'=>'user.update',//编辑保存
        'delete'=>'user.destroy',//删除
    ];
    public function __construct()
    {
        $this->model= new User();

    }
    public function getTitle()
    {
        return[[
            ['type'=>'checkbox'],
            ['field'=>'id','title'=>'ID','sort'=>'true'],
            ['field'=>'name','title'=>'名称'],
            ['field'=>'username','title'=>'登陆名'],
            ['field'=>'email','title'=>'电子邮件'],
            ['field'=>'phone','title'=>'电话'],
            ['field'=>'credits','title'=>'积分','sort'=>'true'],
            ['field'=>'created_at','title'=>'创建时间'],
            ['field'=>'right','title'=>'数据操作','align'=>'center','toolbar'=>'#barDemo','width'=>300]
        ]
        ];
    }
    public function index(Request $request)
    {
        if ($request->ajax()){
            return response()->json($this->getData($request));
        }


        $data['title'] = $this->getTitle();// 标题
        $data['config'] = $this->config;//获取配置
        return view('admin.user.index', compact('data'));
    }
    //会员详情
    public function show($id)
    {
        $payment=new PaymentController();
        $model=$this->model::find($id);
         $config = $this->config;//获取配置
        $data['title'] =$payment->getTitle() ;// 标题
        return view('admin.'.''.$this->config['show'],compact('model','config','data'));
    }
    public function create(){
        return view('admin.user.create');
    }
    public function store(Request $request)
    {
        $data=$this->checkValidate($request,$this->ruler());
        if ($data!==true) {
            return response()->json(['code' => 400, 'msg' => $data]);
        }
        if ($this->model->fill($request->all())->save()){
            return response()->json(['code' => 200, 'msg' => '添加成功']);
        }
    }
    public function ruler(){
        return
            [
            'name'=>'required',
            'username'=>'required',
            'email'=>'required',
            'credits'=>'required',
            'phone'=>'required',
           ];
    }
    public function edit($id)
    {
        $user=User::find($id);
        $data['config'] = $this->config;//获取配置
        return view('admin.user.edit',compact('user','data'));

    }
    public function update(Request $request, $id)
    {
        $data=$this->checkValidate($request,$this->ruler());
        if ($data!==true) {
            return response()->json(['code' => 400, 'msg' => $data]);
        }
        $model=$this->model->find($id);
        $model->fill($request->all());
       if ($model->save()){
            return response()->json(['code' => 200, 'msg' => '修改成功']);
        }

    }
    //获取数据
    public function getData($request){
        $model= $this->model;
        $name=$request->input('name');

        if (!empty($name)){
            $model=$model->where('name','like','%'.$name.'%');
        }
        $limit=$request->limit??'10';
        $count=$model->count();
        $paginate=$model->paginate($limit);
        $data=$paginate->toArray();
        return  $data=['code'=>0,'msg'=>'','count'=>$count,'data'=>$data['data']];
    }


}
