<?php
date_default_timezone_set("Asia/Taipei");
session_start();

// to
function to($url)
{
    header("location:" . $url);
}
// dd
function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

class DB
{
    // 前置
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=web01";
    protected $user = "root";
    protected $pw = "";

    protected $pdo;
    public $table;

    public $title;
    public $button;
    public $header;
    public $append;
    public $upload;

    // construct
    public function __construct($table)
    {
        $this->table = $table;
        $this->pdo = new PDO($this->dsn, $this->user, $this->pw);
        $this->setStr($table);
    }

    // setStr
    private function setStr($table)
    {
        switch ($table) {
            case "title":
                $this->title = "網站標題管理";
                $this->button = "新增網站標題圖片";
                $this->header = "網站標題";
                $this->append = "替代文字";
                $this->upload = "網站標題圖片";
                break;
            case "ad":
                $this->title = "動態文字廣告管理";
                $this->button = "新增動態文字廣告";
                $this->header = "動態文字廣告";
                break;
            case "mvim":
                $this->title = "動畫圖片管理";
                $this->button = "新增動畫圖片";
                $this->header = "動畫圖片";
                $this->upload = "動畫圖片";
                break;
            case "image":
                $this->title = "校園映像資料管理";
                $this->button = "新增校園映像資料";
                $this->header = "校園映像資料圖片";
                $this->upload = "校園映像資料";
                break;
            case "news":
                $this->title = "最新消息資料管理";
                $this->button = "新增最新消息資料";
                $this->header = "最新消息資料內容";
                break;
            case "total":
                $this->title = "進站總人數管理";
                $this->button = "";
                $this->header = "進站總人數";
                break;
            case "bottom":
                $this->title = "頁尾版權資料管理";
                $this->button = "";
                $this->header = "頁尾版權資料";
                break;
            case "admin":
                $this->title = "管理者帳號管理";
                $this->button = "新增管理者帳號";
                $this->header = "帳號";
                $this->append = "密碼";
                break;
            case "menu":
                $this->title = "選單管理";
                $this->button = "新增主選單";
                $this->header = "主選單名稱";
                $this->append = "選單連結網址";
                break;
        }
    }

    // find
    public function find($id)
    {
        $sql = "SELECT * FROM $this->table WHERE ";
        if (is_array($id)) {
            foreach ($id as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }
            $sql .= implode(" AND ", $tmp);
        } else {
            $sql .= " `id`='$id'";
        }
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    // all
    public function all(...$arg)
    {
        $sql = "SELECT * FROM $this->table ";
        switch (count($arg)) {
            case 2:
                foreach ($arg[0] as $key => $value) {
                    $tmp[] = "`$key`='$value'";
                }
                $sql .= " WHERE " . implode(" AND ", $tmp) . " " . $arg[1];
                break;
            case 1:
                if (is_array($arg[0])) {
                    foreach ($arg[0] as $key => $value) {
                        $tmp[] = "`$key`='$value'";
                    }
                    $sql .= " WHERE " . implode(" AND ", $tmp);
                } else {
                    $sql .= $arg[0];
                }
                break;
        }
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // q
    public function q($sql)
    {
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // math
    public function math($method, $col, ...$arg)
    {
        $sql = "SELECT $method($col) FROM $this->table ";
        switch (count($arg)) {
            case 2:
                foreach ($arg[0] as $key => $value) {
                    $tmp[] = "`$key`='$value'";
                }
                $sql .= " WHERE " . implode(" AND ", $tmp) . " " . $arg[1];
                break;
            case 1:
                if (is_array($arg[0])) {
                    foreach ($arg[0] as $key => $value) {
                        $tmp[] = "`$key`='$value'";
                    }
                    $sql .= " WHERE " . implode(" AND ", $tmp);
                } else {
                    $sql .= $arg[0];
                }
                break;
        }
        return $this->pdo->query($sql)->fetchColumn();
    }

    // save
    public function save($array)
    {
        if (isset($array['id'])) {
            foreach ($array as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }
            $sql = "UPDATE $this->table SET " . implode(",", $tmp) . " WHERE `id`='{$array['id']}'";
        } else {
            $sql = "INSERT INTO $this->table (`" . implode("`,`", array_keys($array)) . "`) 
                                    VALUES ('" . implode("','", $array) . "')";
        }
        // echo $sql;
        return $this->pdo->exec($sql);
    }

    // del
    public function del($id)
    {
        $sql = "DELETE FROM $this->table WHERE ";
        if (is_array($id)) {
            foreach ($id as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }
            $sql .= implode(" AND ", $tmp);
        } else {
            $sql .= " `id`='$id'";
        }
        return $this->pdo->exec($sql);
    }
    
}



// -------------
$Title = new DB('title');
$Ad = new DB('ad');
$Image = new DB('image');
$Menu = new DB('menu');
$Mvim = new DB('mvim');
$Bottom = new DB('bottom');
$Total = new DB('total');
$Admin = new DB('admin');
$News = new DB('news');

// session
if (!isset($_SESSION['total'])) {
    // ↓不是$Total->find(1)['total']，這樣才會全部取出，存成陣列到變數total去
    $total = $Total->find(1);
    // 我們才能改其中一個
    $total['total']++;
    // 再全部陣列(id1)存回
    $Total->save($total);
    // 純數字存數字
    $_SESSION['total'] = $total['total'];
}

// tt
$tt=$_GET['do']??'';
switch($tt){
    case "ad":
        $DB=$Ad;
        break;
    case "title":
        $DB=$Title;
        break;
    case "admin":
        $DB=$Admin;
        break;
    case "menu":
        $DB=$Menu;
        break;
    case "mvim":
        $DB=$Mvim;
        break;
    case "total":
        $DB=$Total;
        break;
    case "image":
        $DB=$Image;
        break;
    case "bottom":
        $DB=$Bottom;
        break;
    case "news":
        $DB=$News;
        break;

        default:
        $DB=$Title;
        break;
}


