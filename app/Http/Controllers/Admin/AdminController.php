<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminForm;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends TemplateController
{
    protected $model;
    public $config=[
        'index'=>'admin.index',//首页
        'create'=>'admin.create',//创建
        'store'=>'admin.store',//创建保存
        // 'show'=>'admin.show',//查看
        'edit'=>'admin.edit',//编辑
        'update'=>'admin.update',//编辑保存
        'delete'=>'admin.destroy',//删除
    ];
    public function __construct()
    {
        $this->model= new Admin();

    }
    public function store(AdminForm $request){
        $model=$this->model;
        $role=$request->input('role');
        $data=$request->validated();
        $data['password']=bcrypt($data['password']);
        $model->fill($data);
        if ($model->save()){
            $model->assignRole($role);
            return $this->json();
        }
    }

    public function update(AdminForm $request, $id){
        $model=$this->model->find($id);
        $role=$request->input('role');
        $data=$request->validated();
        $data['password']=bcrypt($data['password']);
        $model->fill($data);
        if ($model->save()){
           $model->syncRoles($role);
                 return $this->json();
        }

    }
    //展示编辑页
    public function edit($id){
        $model=$this->model::find($id);
        $config = $this->config;//获取配置
        $roles=Role::all();
        $role=$model->roles()->first();
        return view('admin.'.''.$this->config['edit'],compact('model','config','roles','role'));
    }
    //展示创建页
    public function create(){
        $config = $this->config;//获取配置
        $roles=Role::all();
        return view('admin.'.$this->config['create'],compact('config','roles'));
    }
    function getTitle()
    {
        return[[
            ['type'=>'checkbox'],
            ['field'=>'id','title'=>'ID','sort'=>'true'],
            ['field'=>'username','title'=>'用户名'],
            ['field'=>'created_at','title'=>'创建时间'],
            ['field'=>'right','title'=>'数据操作','align'=>'center','toolbar'=>'#barDemo','width'=>300]
        ]];

    }
    public function index(Request $request)
    {
        if (!auth('admin')->user()->hasPermissionTo('管理员管理')){
           return redirect(route('permission'));
        }
       if ($request->ajax()){
            return response()->json($this->getData($request));
        }
        $data['title'] = $this->getTitle();// 标题
        $data['config'] = $this->config;//获取配置
        return view('admin.admin.index', compact('data'));
    }
}
