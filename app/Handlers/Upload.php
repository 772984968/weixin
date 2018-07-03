<?php
namespace App\Handlers;
class  Upload{
    public $fileName;
    public $maxImageSize;//允许上传的图片大小
    public $maxFileSize;//允许上传的文件大小
    public $allowImageExt;//图片上传类型
    public $allowFileExt;//文件上传类型
    public $uploadPath;//上传的文件路径
    public $fileInfo;//文件上传信息
    public $error='';//文件上传错误信息
    public $ext;//文件后缀
    public $destination;//文件目的地
    //构造函数
    public function __construct(){
        $this->allowFileExt=['mp3','txt','world','rar','mp4'];
        $this->allowImageExt=['jpeg','jpg','png','gif'];
        $this->maxImageSize=10*1024*1024;
        $this->maxFileSize=5*1024*1024;
       }
       //设置信息
       public function setInfo($fileInfo){
        $this->fileInfo=$fileInfo;
       }
    //单文件上传
    public  function uploadFile(){
        if ($this->cheackError()&&$this->checkSize(1)&&$this->checkExt(1)&&$this->checkHTTPPost()){
            $this->uploadPath=$this->uploadPath.'/'.date('Ymd');
            $this->fileName=$this->getUniName();
            $this->destination=$this->uploadPath.'/'.$this->fileName.'.'.$this->ext;
            if (!$this->checkUploadPath()){
                $this->error='创建文件失败！';
                return false;
            }
            if(move_uploaded_file($this->fileInfo['tmp_name'], $this->destination)){
                return  true;
            }
            return $this->error;
        }
        return $this->error;
    }
    //单图片上传
    public  function uploadImage(){
        if ($this->cheackError()&&$this->checkSize()&&$this->checkExt()&&$this->checkTrueImg()){
            $this->destination="/uploads/images/".date('Ymd').'/';
            $this->uploadPath=public_path().$this->destination;
            $this->fileName=$this->getUniName().'.'.$this->ext;
            $this->destination=$this->destination.$this->fileName;
            // 将图片移动到我们的目标存储路径中
            if ($this->fileInfo->move($this->uploadPath,$this->fileName)){
                return true;
            };
            return $this->error;
        }
        return $this->error;
    }
    // 检测上传文件错误
    public function cheackError()
    {
        if (is_null($this->fileInfo)) {
            $this->error = '文件上传出错';
            return false;
        }
        if ($this->fileInfo->getError()==0) {
             return true;
        }
        switch ($this->fileInfo->getError()) {
            case 1:
                $this->error='超过了PHP配置文件中upload_max_filesize选项的值';
                break;
            case 2:
                $this->error='超过了表单中MAX_FILE_SIZE设置的值';
                break;
            case 3:
                $this->error='文件部分被上传';
                break;
            case 4:
                $this->error='没有选择上传文件';
                break;
            case 6:
                $this->error='没有找到临时目录';
                break;
            case 7:
                $this->error='文件不可写';
                break;
            case 8:
                $this->error='由于PHP的扩展程序中断文件上传';
                break;
        }
        return false;
    }
    //检测上文件大小
    protected function checkSize($type=0){
        if ($type==0){
            if ($this->fileInfo->getSize()<= $this->maxImageSize){
                return  true;
            }
        }
        if ($type==1){
            if ($this->fileInfo->getSize()<= $this->maxFileSize){
                return  true;
            }
        }
        $this->error='文件大小超出了限制';
        return false;
    }
    /**
     * 检测扩展名
     * @return boolean
     */
    protected function checkExt($type=0){
        $this->ext=$this->fileInfo->getClientOriginalExtension();
        if ($type==0){
            if (in_array($this->ext,$this->allowImageExt)){
                return  true;
            }
        }
        if ($type==1){
            if (in_array($this->ext,$this->allowFileExt)){
                return  true;
            }
        }
        $this->error='不允许的扩展名';
        return false;
    }
    /**
     * 检测是否是真实图片
     * @return boolean
     */
    protected function checkTrueImg(){
        if(!@getimagesize($this->fileInfo->getPathname())){
            $this->error='不是真实图片';
            return false;
        }
        return true;
    }
    /**
     * 检测是否通过HTTP POST方式上传上来的
     * @return boolean
     */
    protected function checkHTTPPost(){
        if(!is_uploaded_file($this->fileInfo['tmp_name'])){
            $this->error='文件不是通过HTTP POST方式上传上来的';
            return false;
        }
        return true;
    }
    /**
     * 检测目录不存在则创建
     */
    protected function checkUploadPath(){
        if(!file_exists($this->uploadPath)){
            return  mkdir($this->uploadPath,0777,true);
        }
        return true;
    }
    /**
     * 产生唯一字符串
     * @return string
     */
    protected function getUniName(){
        return md5(uniqid(microtime(true),true));
    }
    public function getUrl(){
        if ($this->error!=''||$this->destination==''){
            return $this->error;
        }
       // return "http://".$_SERVER['HTTP_HOST'].$this->destination;
        return $this->destination;
    }
}