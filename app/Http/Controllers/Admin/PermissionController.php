<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends TemplateController
{
    protected $model;
    public $config=[
        'index'=>'permission.index',//首页
        'create'=>'permission.create',//创建
        'store'=>'permission.store',//创建保存
        // 'show'=>'role.show',//查看
        'edit'=>'permission.edit',//编辑
        'update'=>'permission.update',//编辑保存
        'delete'=>'permission.destroy',//删除
    ];
    public function __construct()
    {
        $this->model= new Permission();

    }
    public function update(Request $request,$id){
        $role=\Spatie\Permission\Models\Permission::find($id);
        if ($role->update(['name'=>$request->input('name')])){
            return $this->json();
        };
        return response()->json(['code' => 400, 'msg' => '修改失败']);
    }

        public function store(Request $request){
        if (\Spatie\Permission\Models\Permission::create(['name'=>$request->input('name'),'guard_name'=>'admin'])){
            return $this->json();
        };
        return response()->json(['code' => 400, 'msg' => '添加失败']);
    }
    function getTitle()
    {
        return[[
            ['type'=>'checkbox'],
            ['field'=>'id','title'=>'ID','sort'=>'true'],
            ['field'=>'name','title'=>'权限名称'],
            ['field'=>'created_at','title'=>'创建时间'],
            ['field'=>'right','title'=>'数据操作','align'=>'center','toolbar'=>'#barDemo','width'=>300]
        ]];

    }

}
