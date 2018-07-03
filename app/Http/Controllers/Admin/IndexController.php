<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends BaseController
{
    /*
     * @return view
     * 用户首页
     */
    public  function  index(){
        return view('admin.index.index');

    }
    public  function welcome(){
        return view('admin.index.welcome');
    }
    //权限
    public function permission(){
         return view('admin.message.permission');
    }

}
