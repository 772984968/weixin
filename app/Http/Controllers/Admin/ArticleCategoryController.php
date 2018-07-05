<?php

namespace App\Http\Controllers\Admin;

use App\Models\ArticleCat;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleCategoryController extends TemplateController
{

    protected $model;
    public $config=[
        'index'=>'articleCategory.index',//首页
        'create'=>'articleCategory.create',//创建
        'store'=>'articleCategory.store',//创建保存
        // 'show'=>'articleCategory.show',//查看
        'edit'=>'articleCategory.edit',//编辑
        'update'=>'articleCategory.update',//编辑保存
        'delete'=>'articleCategory.destroy',//删除
    ];
    public function __construct()
    {
        $this->model= new ArticleCategory();

    }
    public function store(Request $request)
    {

        $model = $this->model;
        $data=array_filter($request->all());
        $model->fill($data);
        if ($model->save()) {
            return response()->json(['code' => 200, 'msg' => '添加成功']);
        } else {
            return response()->json(['code' => 400, 'msg' => '添加失败']);
        }


    }
    function getTitle()
    {
        return[[
            ['type'=>'checkbox'],
            ['field'=>'id','title'=>'ID','sort'=>'true'],
            ['field'=>'name','title'=>'标题'],
            ['field'=>'show_in_nav','title'=>'是否导航显示'],
            ['field'=>'sort','title'=>'排序'],
            ['field'=>'keywords','title'=>'关键字'],
            ['field'=>'desc','title'=>'描述'],
            ['field'=>'right','title'=>'数据操作','align'=>'center','toolbar'=>'#barDemo','width'=>300]
        ]];
    }
    //展示创建页
    public function create(){
        $config = $this->config;//获取配置
        return view('admin.'.$this->config['create'],compact('config'));
    }
}
