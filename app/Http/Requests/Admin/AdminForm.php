<?php
namespace App\Http\Requests\Admin;
class AdminForm extends CommonForm
{
     public function rules()
    {
        return [
            'username'=>'required',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
        ];
    }
    public function messages(){

        return [
            'username.required'=>'用户名必须',
            'username.unique'=>'用户名已存在',
            'password.required'=>'密码必须',
            'password.confirmed'=>'两次密码不匹配',
            'password_confirmation.required'=>'验证码必须',
              ];

    }
}
