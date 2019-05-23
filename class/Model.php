<?php
$config = [
    'DB_HOST' => 'localhost',
    'DB_USER' => 'root',
    'DB_PWD' => 'yx110120',
    'DB_NAME' => 'user',
    'DB_CHARSET' => 'utf8',
    'DB_PREFIX' => ''
];
$data = ['name' => 'yangxin', 'age' => 10];
$m = new Model($config);

$m->table('users')->select();
$m->table('users')->insert($data);
$m->table('users')->where('id=3')->delete();
$m->table('users')->where('id=3')->update($data);
$m->table('users')->getByUsername('admin888');

class Model
{
    //主机名
    protected $host;
    //用户名
    protected $user;
    //密码
    protected $pwd;
    //数据库名
    protected $dbname;
    //字符集
    protected $charset;
    //数据表前缀
    protected $prefix;
    //数据库连接资源
    protected $link;
    //数据表名
    protected $tableName;
    //SQL语句
    protected $sql;
    //操作数组 存放的就是所有的查询条件
    protected $options;
    //构造方法
    public function __construct($config)
    {
        $this->host = $config['DB_HOST'];
        $this->user = $config['DB_USER'];
        $this->pwd = $config['DB_PWD'];
        $this->dbname = $config['DB_NAME'];
        $this->charset = $config['DB_CHARSET'];
        $this->prefix = $config['DB_PREFIX'];
        //连接数据库
        $this->link = $this->connect();
        //得到数据表名
        $this->tableName = $this->getTableName();
        //初始化options数组
        $this->initOptions();
    }

    protected function connect()
    {
        $link = mysqli_connect($this->host, $this->user, $this->pwd);
        if (!$link) {
            die('数据库连接失败');
        }
        //选择数据库
        mysqli_select_db($link, $this->dbname);
        //设置字符集编码
        mysqli_set_charset($link, $this->charset);
        //返回连接成功的资源
        return $link;
    }

    protected function getTableName()
    {
        //如果设置了成员变量，来通过成员变量来的到表名
        if (!empty($this->tableName)) {
            return $this->prefix . $this->tableName;
        }
        //如果没有设置成员表名，那么通过类名来得到表名
        $className = get_class($this);
        $table = strtolower(substr($className, 0, -5));
        return $this->prefix . $table;
    }

    protected function initOptions()
    {
        $arr = ['where', 'table', 'field', 'order', 'group', 'having', 'limit'];
        foreach ($arr as $value) {
            //将options数组中的这些健对应的值全部清空
            $this->options[$value] = '';
            //设置table默认设置为tableName
            if ($value == 'table') {
                $this->options['$value'] = $this->tableName;
            } elseif ($value == 'field') {
                $this->options[$value] = '*';
            }
        }
    }

    //查询相关方法
    //filed方法
    function field($field)
    {
        if (!empty($field)) {
            if (is_string($field)) {
                $this->options['field'] = $field;
            } elseif (is_array($field)) {
                $this->options['field'] = join(',', $field);
            }
        }
        return $this;
    }
    //table方法
    function table($table)
    {
        if (!empty($table)) {
            $this->options['table'] = $table;
        }
        return $this;
    }
    //where方法

    function where($where)
    {
        if (!empty($where)) {
            $this->options['where'] = 'where ' . $where;
        }
        return $this;
    }
    //group方法
    function group($group)
    {
        if (!empty($group)) {
            $this->options['group'] = 'group by ' . $group;
        }
        return $this;
    }
    //having方法
    function having($having)
    {
        if (!empty($having)) {
            $this->options['having'] = 'having ' . $having;
        }
        return $this;
    }
    //oder方法
    function order($order)
    {
        if (!empty($order)) {
            $this->options['order'] = 'order by ' . $order;
        }
        return $this;
    }
    //limit方法
    function limit($limit)
    {
        if (!empty($limit)) {
            if (is_string($limit)) {
                $this->options['limit'] = 'limit ' . $limit;
            } elseif (is_array($limit)) {
                $this->options['limit'] = 'limit ' . json(',', $limit);
            }
        }
        return $this;
    }
    //select方法
    function select()
    {
        //先预写一个带有占位符的SQL语句 
        $sql = 'select %FIELD% from %TABLE% %WHERE% %GROUP% %HAVING% %ORDER% %LIMIT%';
        //将options中的值一次替换占位符
        $sql = str_replace(
            ['%FIELD%', '%TABLE%', '%WHERE%', '%GROUP%', '%HAVING%', '%ORDER%', '%LIMIT%'],
            [$this->options['field'], $this->options['table'], $this->options['where'], $this->options['group'], $this->options['having'], $this->options['order'], $this->options['limit']],
            $sql
        );
        $this->sql = $sql;
        return $this->query($sql);
    }

    function query($sql)
    {
        //清空options数组
        $this->initOptions();
        $data = array();
        $result = mysqli_query($this->link, $sql);
        if ($result && mysqli_affected_rows($this->link)) {
            while ($item = mysqli_fetch_assoc($result)) {
                $data[] = $item;
            }
        }
        if (!$result) {
            # code...
        }
        var_dump($data);
        return $data;
    }

    //insert函数
    //$data:关联数组，健就是字段名，值就是字段值
    function insert($data)
    {
        //处理字符串问题，两边需要加引号
        $data = $this->parseValue($data);
        //提取所有的字段
        $keys = array_keys($data);
        //提取所有的值;
        $values = array_values($data);
        //增加数据的sql语句
        $sql = 'insert into %TABLE%($FIELD$) values(%VALUES%)';
        $sql = str_replace(
            ['%TBBLE%', '%FIELD%', '%VALUES%'],
            [$this->options['table'], join(',', $keys), join(',', $values)],
            $sql
        );
        $this->sql = $sql;
        return $this->exec($sql, true);
    }

    //执行SQL语句
    function exec($sql, $isInsert = false)
    {
        //清空options数组
        $this->initOptions();
        $result = mysqli_query($this->link, $sql);
        if ($result && mysqli_affected_rows($this->link)) {
            //判断是否插入语句，根据不同的语句返回不同的结果
            if ($isInsert) {
                return mysqli_insert_id($this->link);
            } else {
                return mysqli_affected_rows($this->link);
            }
        }
        return false;
    }

    protected function parseValue($data)
    {
        //遍历数组，判断是否是字符串，若是字符串，将两边添加引号
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $value = '"' . $value . '"';
            }
            $data[$key] = $value;
        }
        //返回处理后的结果
        return $data;
    }

    //删除函数
    function delete()
    {   //拼接SQL语句
        $sql = 'delete from %TABLE% %WHERE%';
        $sql = str_replace(['%TABLE%', '%WHERE%'], [$this->options['table'], $this->options['where']], $sql);
        $this->sql = $sql;

        return $this->exec($sql);
    }

    //更新函数
    function update($data)
    {
        //处理$data数组中值为字符串加引号的问题
        $data = $this->parseValue($data);
        //将关联数组拼接为固定的格式 健=值
        $value = $this->parseUpdate($data);
        //准备SQL语句
        $sql = 'update %TABLE% set %VALUE% %WHERE%';
        $sql = str_replace(
            ['%TABLE%', '%VALUE%', '%WHERE%'],
            [$this->options['table'], $value, $this->options['where']],
            $sql
        );
        var_dump($sql);
        // $this->sql = $sql;
        // return $this->exec($sql);
    }

    protected function parseUpdate($item)
    {
        foreach ($item as $key => $value) {
            $data[] = $key . '=' . $value;
        }
        return join(',', $data);
    }

    //sql语句
    function __get($name)
    {
        if ($name == 'sql') {
            return  $this->sql;
        }
        return false;
    }
    //max函数
    function max($field)
    {
        $result = $this->field('max(' . $field . ') as max')->select();
        return $result[0]['max'];
    }

    //关闭数据库连接 析构方法
    function __destruct()
    {
        mysqli_close($this->link);
    }

    //getByName getByAge
    function __call($name, $args)
    {
        //获取前5个字符
        $str = substr($name, 0, 5);
        //获取后面的字段名
        $field = strtolower(substr($name, 5));
        //判断前五个字符是否是getby
        if ($str == 'getBy') {
            return $this->where($field . '="' . $args[0] . '"')->select();
        }
        return false;
    }
}
