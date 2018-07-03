<?php
namespace App\libraries\Curl;
/**
 *
 *curl封装类
 *
 */
class  Curl {

/**
 *  get方式模拟请求
 * @param unknown $url
 * @param unknown $data
 * @return number[]|number[]|unknown[]
 */
   public function sendGet($url,$data){
       $ch=curl_init($url.'?'.http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // true表示不主动输出内容false表示输出返回的内容
        curl_setopt($ch, CURLOPT_TIMEOUT, 20); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 拒绝验证证书自cURL 7.10开始默认为TRUE。从cURL 7.10开始默认绑定安装
        curl_setopt($ch, CURLOPT_HEADER, 0); // 不将头信息返回
        $rs = curl_exec($ch);
        if(curl_errno($ch))
        {
            $error=['code'=>400,'error'=>curl_errno($ch)];
            curl_close($ch);
            return $error;
        }
        curl_close($ch);
        return ['code'=>200,'data'=>$rs];
    }

    /**
     *post方式模拟请求
     * @param unknown $url
     * @param unknown $data
     * @param array $header
     * @return number[]|number[]|unknown[]
     */
    public static function sendPost($url,$data,$header=[])
    {
        $ch = curl_init($url);
        if (!empty($header)){
            curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        }
        $data=http_build_query($data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);//true表示不主动输出内容false表示输出返回的内容
        curl_setopt($ch,CURLOPT_POST,1);//post方式提交
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);//表单提交数据
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//拒绝验证证书自cURL 7.10开始默认为TRUE。从cURL 7.10开始默认绑定安装
        curl_setopt($ch, CURLOPT_TIMEOUT,30);//设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_HEADER, 0);//不将头信息返回

        $rs=curl_exec($ch);

        if(curl_errno($ch))
        {


           $error=['code'=>400,'error'=>curl_errno($ch)];
           curl_close($ch);
           return $error;
        }
        curl_close($ch);
        return ['code'=>200,'data'=>$rs];

    }

}
