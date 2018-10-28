<?php
/**
 * 配置文件
 */
session_start();
if(empty($_SESSION['loginStatus']['status']) || !$_SESSION['loginStatus']['status']) {
    header('Location:/login.php');// 跳转到登录页面
    exit;
}
$siteTitle='蓝悉科技'; // 站点标题
$siteSubtitle='选品管理系统'; // 站点副标题
$dbname = md5($siteTitle.$siteSubtitle);


class LANTHY{
	public $db;
	function __construct($dbfile=null){
		try{
			$this->db=new SQLite3($dbfile?$dbfile:"db",SQLITE3_OPEN_READONLY);
		}catch(Exception $e){
			header('HTTP/1.1 503 Service Temporarily Unavailable');
			header('Status: 503 Service Temporarily Unavailable');
			header('Retry-After: 3600');
			echo "<h2>Database error. 503 Service Temporarily Unavailable</h2><p>".$e->getMessage()."</p>";
			header('Location:/login.php');// 跳转到登录页面
			die();
		}
	}
	function __destruct(){
		if($this->db)$this->db->close();
	}
	function getData($sql){
		$result=$this->db->query($sql) or die("Error:".$sql);
		$ret=array();
		while($row=$result->fetchArray(SQLITE3_ASSOC))$ret[]=$row;
		$result->finalize();
		unset($result);
		unset($row);
		return $ret;
	}
	function getLine($sql,$type=true){
		return $this->db->querySingle($sql,$type);
    }
    /**
     * getUser
     */
	function getUsers(){
        $sql="SELECT rowid,* FROM hlong_user WHERE user_auth < 9";
		return $this->getData($sql);
    }
    /**
     * getCategory
     */
    function getCategory($id){
        $sql="SELECT rowid,* FROM hlong_category WHERE rowid = ".intval($id);
		return $this->getLine($sql);
    }
    /**
     * getCategories
     */
    function getCategories($id=0){
        $sql="SELECT rowid,* FROM hlong_category WHERE category_father_id = ".intval($id);
		return $this->getData($sql);
    }
    /**
     * getProduct
     */
    function getProduct($id){
        $sql="SELECT rowid,* FROM hlong_products WHERE rowid = ".intval($id);
        return $this->getLine($sql);
    }
    /**
     * getProducts
     */
    function getProducts($id=0){
        $sql="SELECT rowid,* FROM hlong_products WHERE product_category_id = ".intval($id);
		return $this->getData($sql);
    }
}

// 格式时间
function format_date($time){
    $t=time()-$time;
    $f=array(
        '31536000'=>'年',
        '2592000'=>'个月',
        '604800'=>'星期',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $c.$v.'前';
        }
    }
}
// 实例化
$lanthy = New LANTHY("{$_SERVER['DOCUMENT_ROOT']}/DATA/{$dbname}");