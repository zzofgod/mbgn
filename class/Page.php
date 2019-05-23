<?php

class Page
{
    //每页显示多少条数据
    protected $number;
    //一共有多少条数据
    protected $totalCount;
    //当前页
    public $page;
    //总页数
    public $totalPage;
    //url
    protected $url;

    public function __construct($number, $totalCount)
    {
        $this->number = $number;
        $this->totalCount = $totalCount;
        $this->totalPage = $this->getTotalPage();
        $this->page = $this->getPage();
        $this->url = $this->getUrl();
    }

    //得到总页数
    protected function getTotalPage()
    {
        return ceil($this->totalCount / $this->number);
    }

    //得到当前页数
    protected function getPage()
    {
        if (empty($_GET['page'])) {
            $page = 1;
        } else if ($_GET['page'] > $this->totalPage) {
            $page = $this->totalPage;
        } else {
            $page = $_GET['page'];
        }
        return $page;
    }
    protected function getUrl()
    {
        //得到协议名
        $scheme = $_SERVER['REQUEST_SCHEME'];
        //得到主机名
        $host = $_SERVER['SERVER_NAME'];
        //得到端口号
        $port = $_SERVER['SERVER_PORT'];
        //得到路径和请求字符串
        $uri = $_SERVER['REQUEST_URI'];

        $uriArray = parse_url($uri);
        $path = $uriArray['path'];
        if (isset($uriArray['query'])) {
            //首先将请求参数变为关联数组
            parse_str($uriArray['query'], $array);
            //清楚page参数
            unset($array['page']);
            //将剩下的参数拼接成字符串
            $query = http_build_query($array);
            //再将请求字符串拼接路径后面
            if ($query != '') {
                $path = $path . '?' . $query;
            }
        }
        return $scheme . '://' . $host . ':' . $port .  $path;
    }

    protected function setUrl($str)
    {
        if (strstr($this->url, '?')) {
            $url = $this->url . '&' . $str;
        } else {
            $url = $this->url . '?' . $str;
        }
        return $url;
    }

    public function allUrl()
    {
        return [
            'first' => $this->first(),
            'prev' => $this->prev(),
            'next' => $this->next(),
            'end' => $this->end()
        ];
    }

    public function first()
    {
        return $this->setUrl('page=1');
    }

    public function next()
    {
        if ($this->page + 1 > $this->totalPage) {
            $page = $this->totalPage;
        } else {
            $page = $this->page + 1;
        }
        return $this->setUrl('page=' . $page);
    }

    public function prev()
    {
        if ($this->page - 1 < 1) {
            $page = 1;
        } else {
            $page = $this->page - 1;
        }
        return $this->setUrl('page=' . $page);
    }

    public function end()
    {

        return $this->setUrl('page=' . $this->totalPage);
    }

    public function limit()
    {
        $offset = ($this->page - 1) * $this->number;
        return $offset . ',' . $this->number;
    }
}
