<?php

namespace App\Http\Controllers\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RolesController extends TemplateController
{
    protected $model;
    public $config=[
        'index'=>'roles.index',//首页
        'create'=>'roles.create',//创建
        'store'=>'roles.store',//创建保存
        'show'=>'roles.show',//查看
        'edit'=>'roles.edit',//编辑
        'update'=>'roles.update',//编辑保存
        'delete'=>'roles.destroy',//删除
    ];
    public function __construct()
    {
        $this->model= new Role();

    }
    public function store(Request $request){
        if (\Spatie\Permission\Models\Role::create(['name'=>$request->input('name'),'guard_name'=>'admin'])){
            return $this->json();
        };
        return response()->json(['code' => 400, 'msg' => '添加失败']);
    }

    public function update(Request $request,$id){
        $role=\Spatie\Permission\Models\Role::find($id);
          if ($role->update(['name'=>$request->input('name')])){
            return $this->json();
        };
        return response()->json(['code' => 400, 'msg' => '修改失败']);
    }
    //添加权限
    public function addPermission(Request $request){
        $id=$request->input('id');
        $permissions=$request->input('permission');
        $role=\Spatie\Permission\Models\Role::find($id);
        $permission_arr=Permission::whereIn('id',$permissions)->get();
        if ( $role->syncPermissions($permission_arr)){
            return $this->json();
        };
        return response()->json(['code' => 400, 'msg' => '修改失败']);
    }
    function getTitle()
    {
        return[[
            ['type'=>'checkbox'],
            ['field'=>'id','title'=>'ID','sort'=>'true'],
            ['field'=>'name','title'=>'用户名'],
            ['field'=>'created_at','title'=>'创建时间'],
            ['field'=>'right','title'=>'数据操作','align'=>'center','toolbar'=>'#barDemo','width'=>300]
        ]];

    }


    public function show($id)
    {
        $model=\Spatie\Permission\Models\Role::find($id);
        $config = $this->config;//获取配置
        //获取所有权限
        $permission=Permission::all();
        //获取角色所有权限
        $roles=$model->permissions()->pluck('id')->toArray();

        return view('admin.'.''.$this->config['show'],compact('model','config','permission','roles'));
    }
    public function index(Request $request)
    {
        if ($request->ajax()){
            return response()->json($this->getData($request));
        }


        $data['title'] = $this->getTitle();// 标题
        $data['config'] = $this->config;//获取配置
        return view('admin.roles.index', compact('data'));
    }

}
