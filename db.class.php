<?php
class mysqliBaseClass {

    public $connect;

    public function __construct() {
        $this->connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit;
        }
    }

    public function getObject($result)
    {
        $i = 0;
        while($obj = mysqli_fetch_object($result))
        {
            $obje[$i] = $obj;
            $i++;
        }
        return $obje;
    }

    public function findQuery($select, $from, $joins = '', $where = '', $group = '', $order = '', $limit = '')
    {
        $query = '';
        if(is_array($select)) {
            $query = 'SELECT ' . implode(',', $select) . ' FROM ' . $from;
        } else {
            $query = 'SELECT ' . $select . ' FROM ' . $from;
        }
        
        if(trim($joins) <> '') {
            $query .= ' ' . $joins;
        }
        if(trim($where) <> '') {
            $query .= ' WHERE ' . $where;
        }
        if(trim($group) <> '') {
            $query .= ' GROUP BY ' . $group;
        }
        if(trim($order) <> '') {
            $query .= ' ORDER BY ' . $order;
        }
        if(trim($limit) <> '') {
            $query .= ' LIMIT ' . $limit;
        }
        
        $res = mysqli_query($this->connect, $query);
        if(mysqli_num_rows($res) > 0)
        {
            $obj = $this->getObject($res);
            return $obj = $obj[0]->emp_name;
        }
        else
        {
            return false;
        }
    }
}