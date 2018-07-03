<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminForm;
use App\Models\Admin;
use Illuminate\Http\Request;

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
        $data=$request->validated();
        $data['password']=bcrypt($data['password']);
        $model->fill($data);
        if ($model->save()){
            return $this->json();
        }
    }

    public function update(AdminForm $request, $id){
        $model=$this->model->find($id);
        $data=$request->validated();
        $data['password']=bcrypt($data['password']);
        $model->fill($data);
        if ($model->save()){
            return $this->json();
        }

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
}
