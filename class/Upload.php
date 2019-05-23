<?php
class Upload
{
    //上传保存路径
    protected $path = '../static/img/';
    //上传格式
    protected $allowSuffix = ['jpg', 'jpeg', 'png', 'gif'];
    //允许的mime
    protected $allowMime = ['image/jpeg', 'image/jpeg', 'image/png', 'image/gif'];
    //最大大小
    protected $maxSize = 20000000;
    //随机图片名称
    protected $isRandName = true;
    //文件前缀
    protected $prefix = 'avatar-';
    //错误号码
    protected $errorNumber;
    //错误信息
    protected $errorInfo;
    //文件信息
    protected $oldName;
    //文件后缀
    protected $suffix;
    //文件的大小
    protected $size;
    //文件的mime
    protected $mime;
    //临时文件的名字
    protected $tmpName;
    //新文件名称
    protected $newName;

    public function __construct($arr = [])
    {
        foreach ($arr as $key => $value) {
            $this->setOption($key, $value);
        }
    }
    //判断这个$key是不是成员属性，如果是，则设置
    protected function setOption($key, $value)
    {
        //得到所有的成员属性
        $keys = array_keys(get_class_vars(__CLASS__));
        //如果$key是我的成员属性，则设置
        if (in_array($key, $keys)) {
            $this->$key = $value;
        }
    }
    //文件上传函数
    //$key 就是input框中的name属性
    public function uploadFile($key)
    {
        //判断没有没有设置路径path}
        if (empty($this->path)) {
            $this->setOption('errorNumber', -1);
            return false;
        }
        //判断该路径是否存在，是否可写
        if (!$this->check()) {
            $this->setOption('errorNumber', -2);
            return false;
        }
        //判断$_FILES里面的error信息是否为0,
        //如果是0，说明文件信息在服务端可以直接获取，提取信息保存到成员属性中
        $error = $_FILES[$key]['error'];
        if ($error) {
            $this->setOption('errorNumber', $error);
            return false;
        } else {
            //提取文件相关信息，并且保存到成员属性中
            $this->getFileInfo($key);
        }
        //判断文件的大小、mime、后缀是否符合
        if (!$this->checkSize() || !$this->checkMime() || !$this->checkSuffix()) {
            return false;
        }
        //得到新的文件名字
        $this->newName = $this->createNewName();

        //判断是否是上传文件，并且移动上传文件
        if (is_uploaded_file($this->tmpName)) {

            if (move_uploaded_file($this->tmpName, $this->path . $this->newName)) {
                return $this->path . $this->newName;
            } else {
                $this->setOption('errorNumber', -7);
                return false;
            }
        } else {
            $this->setOption('errorName', -6);
            return false;
        }
    }

    protected function check()
    {
        //文件夹不存在，或者不是目录，创建文件夹
        if (!file_exists($this->path) || !is_dir($this->path)) {
            return mkdir($this->path, 0777, true);
        }

        //判断文件是否可写
        if (!is_writable($this->path)) {
            return chmod($this->path, 0777);
        }

        return true;
    }

    protected function getFileInfo($key)
    {
        //得到文件名字
        $this->oldName = $_FILES[$key]['name'];
        //得到文件的mime类型
        $this->mime = $_FILES[$key]['type'];
        //得到文件临时路径
        $this->tmpName = $_FILES[$key]['tmp_name'];
        //得到文件大小
        $this->size = $_FILES[$key]['size'];
        //得到文件后缀
        $this->suffix = pathinfo($this->oldName)['extension'];
    }

    protected function checkSize()
    {
        if ($this->size > $this->maxSize) {
            $this->setOption('errorNumber', -3);
            return false;
        }
        return true;
    }

    protected function checkMime()
    {
        if (!in_array($this->mime, $this->allowMime)) {
            $this->setOption('errorNumber', -4);
            return false;
        }
        return true;
    }

    protected function checkSuffix()
    {
        if (!in_array($this->suffix, $this->allowSuffix)) {
            $this->setOption('errorNumber', -5);
            return false;
        }
        return true;
    }

    protected function createNewName()
    {
        if ($this->isRandName) {
            $name = $this->prefix . uniqid() . '.' . $this->suffix;
        } else {
            $name = $this->prefix . $this->oldName;
        }
        return $name;
    }
    public function __get($name)
    {
        if ($name == 'errorNumber') {
            return $this->errorNumber;
        } else if ($name == 'errorInfo') {
            return $this->getErrorInfo();
        }
    }

    protected function getErrorInfo()
    {
        $str = '';
        switch ($this->errorNumber) {
            case -1:
                $str = '文件路径没有设置';
                break;
            case -2:
                $str = '文件路径不是目录或者没有权限';
                break;
            case -3:
                $str = '文件大小超过指定范围';
                break;
            case -4:
                $str = '文件mime类型不符合';
                break;
            case -5:
                $str = '文件后缀不符合';
                break;
            case -6:
                $str = '不是上传文件';
                break;
            case -7:
                $str = '文件上传失败';
                break;
            case 1:
                $str = '文件超出php.ini设置大小';
                break;
            case 2:
                $str = '文件超出html设置大小';
                break;
            case 3:
                $str = '文件部分上传';
                break;
            case 4:
                $str = '没有上传文件';
                break;
            case 6:
                $str = '找不到临时文件';
                break;
            case 7:
                $str = '文件写入失败';
                break;
        }
        return $str;
    }
}
