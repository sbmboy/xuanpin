<?php
/**
 * 安装登录
 *
 */
session_start();
$siteTitle='蓝悉科技'; // 站点标题
$siteSubtitle='选品管理系统'; // 站点副标题
$dbname = md5($siteTitle.$siteSubtitle);
if(!file_exists('DATA/'.$dbname)){
    $title="安装";
    $install=true;
}else{
    $title="登录";
    $install=false;
}
// 检查是否为安装程序
if(isset($_POST['install'])){
  set_time_limit(0);
  $username=trim($_POST['username']);
  $nickname=trim($_POST['nickname']);
  $passwd=trim($_POST['passwd']);
  $email=trim($_POST['email']);
  if($username!=''&&$nickname!=''&&$passwd!=''&&$email!=''){
    if(!is_dir('DATA')) mkdir('DATA');
    if(!is_dir('FILES')) mkdir('FILES');
	if(!extension_loaded('sqlite3')) die("检查php.in文件是否支持sqlite3数据库！");
    $db = new SQLite3("DATA/{$dbname}",SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
	$db->exec("begin exclusive transaction");
	// 创建user表
    $db->exec("CREATE TABLE \"hlong_user\" (
  		\"user_nicename\" varchar(255),  /*昵称*/
  		\"user_username\" varchar(255),  /*用户名*/
  		\"user_password\" varchar(255),  /*密码*/
  		\"user_email\" varchar(255),     /*邮箱*/
  		\"user_logintime\" INTEGER,      /*最后登录时间*/
  		\"user_group\" varchar(255),     /*权限*/
  		\"user_auth\" varchar(255),      /*所属组*/
  		\"user_status\" varchar(255),    /*状态*/
  		\"user_remark\" TEXT)            /*备注信息*/
	");
    $db->exec("CREATE UNIQUE INDEX user_username on hlong_user (user_username)");
    $db->exec("CREATE INDEX user_logintime on hlong_user (user_logintime DESC)");
    $passwd=md5($passwd.$siteTitle);
    $username=$db->escapeString($username);
    $nickname=$db->escapeString($nickname);
    $passwd=$db->escapeString($passwd);
    $email=$db->escapeString($email);
	// 写入超级管理员
    $sql="INSERT INTO hlong_user (\"user_nicename\", \"user_username\", \"user_password\", \"user_email\", \"user_logintime\", \"user_group\", \"user_auth\", \"user_status\", \"user_remark\") 
    VALUES ('{$nickname}','{$username}','{$passwd}','{$email}',NULL,NULL,9,'enable','超级管理员')";
    $db->exec($sql);
    // 创建分类管理表
    $db->exec("CREATE TABLE \"hlong_category\" (
  		\"category_name\" varchar,             /*名称*/
        \"category_desc\" TEXT,                /*简介*/
        \"category_path\" varchar,             /*保存路径*/
        \"category_father_id\" varchar,        /*父级id*/
  		\"category_child_counts\" INTEGER,     /*子分类数*/
  		\"category_products_counts\" INTEGER)   /*文件数*/
    ");
    $db->exec("CREATE UNIQUE INDEX category_category_name on hlong_category (category_name)");
    $db->exec("CREATE INDEX category_father_id on hlong_category (category_father_id)");
    // 创建资源信息表
    $db->exec("CREATE TABLE \"hlong_products\" (
        \"product_category_id\" INTEGER,   /*分类id*/
        \"product_title\" varchar,         /*产品名*/
        \"product_path\" varchar,          /*产路径*/
        \"product_tag\" varchar,           /*产品tag*/
        \"product_desc\" varchar,          /*产品描述*/
        \"product_posttime\" varchar,      /*创建时间*/
        \"product_user\" varchar,          /*创建者*/
        \"product_image_counts\" INTEGER,  /*图片数量*/
        \"product_video_counts\" INTEGER,  /*视频数量*/
        \"product_other_counts\" INTEGER,  /*其他文件*/
        \"product_downloadtimes\" INTEGER) /*下载次数*/
    "); 
    $db->exec("CREATE UNIQUE INDEX products_product_path on hlong_products (product_path)");
    $db->exec("CREATE INDEX products_product_category_id on hlong_products (product_category_id)");
    $db->exec("CREATE INDEX products_product_posttime on hlong_products (product_posttime DESC)");
    $db->exec("CREATE INDEX products_product_user on hlong_products (product_user)");
    $db->exec("CREATE INDEX products_product_downloadtimes on hlong_products (product_downloadtimes)");

    // 创建tag表
    $db->exec("CREATE TABLE \"hlong_tags\" (
        \"tag_title\" varchar,    /*tag*/
        \"tag_product_ids\" TEXT, /*products ids*/      
        \"tag_counts\" INTEGER)   /*counts*/
    ");
    $db->exec("CREATE UNIQUE INDEX tags_tag_title on hlong_tags (tag_title)");
    $db->exec("CREATE INDEX tags_tag_counts on hlong_tags (tag_counts DESC)");

    // 创建filesinfo表
    $db->exec("CREATE TABLE \"hlong_filesinfo\" (
        \"file_product_id\" INTEGER,    /*product id*/
        \"file_title\" varchar,         /*文件名*/
        \"file_path\" varchar,          /*文件路径*/
        \"file_size\" INTEGER,          /*文件大小*/
        \"file_type\" varchar,          /*文件类型*/
        \"file_posttime\" INTEGER,      /*添加时间*/
        \"file_author\" varchar,          /*文件作者*/
        \"file_downloadtimes\" INTEGER) /*下载次数*/
    ");
    $db->exec("CREATE UNIQUE INDEX filesinfo_file_path on hlong_filesinfo (file_path)");
    $db->exec("CREATE INDEX filesinfo_file_product_id on hlong_filesinfo (file_product_id DESC)");

    // 关闭数据库
	$db->exec("end transaction");
    $db->close();
	header("Content-type:text/html;charset=utf-8");
	echo '<script>alert("安装成功！");window.location.href="/login.php";</script>';
  }else{
	header("Content-type:text/html;charset=utf-8");
	echo '<script>alert("安装失败！请填入完整信息！");window.location.href="/login.php";</script>';
  }
  exit;
}
// 登录
if(isset($_POST['login'])){
    if(!empty($_POST['username'])&&!empty($_POST['passwd'])){
		$db=new SQLite3("DATA/{$dbname}",SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
		$sql="SELECT rowid,* FROM `hlong_user` WHERE user_username = '{$_POST['username']}' AND user_password = '".md5($_POST['passwd'].$siteTitle)."'";
		$result=$db->query($sql);
		$row=$result->fetchArray(SQLITE3_ASSOC);
		if($row){
			if($row['user_status']=='disable'){
                $result->finalize();
                unset($result);
                $db->close();
                header("Content-type:text/html;charset=utf-8");
                echo '<script type="text/javascript">alert("对不起 '.$row['user_username'].'，你的账户已经被禁用，请联系管理员。");window.location.href="/login.php";</script>';
                exit;
            }else{
                $_SESSION['loginStatus']=array(
                    'username' => $row['user_username'],
                    'email' => $row['user_email'],
                    'nickname' => $row['user_nicename'],
                    'auth' => $row['user_auth'],
                    'status' =>true,
                    'loginTime' => time(),
                );
                $sql="UPDATE \"hlong_user\" SET \"user_logintime\" = '".time()."' WHERE \"user_username\" = '{$row['user_username']}'";
                $db->exec($sql) or print($sql);
                $result->finalize();
                $db->close();
                unset($result);
                unset($row);
                header('Location:/index.php');
                exit;
            }
		}else{//若查到的记录不对，则设置错误信息
            header("Content-type:text/html;charset=utf-8");
            echo '<script type="text/javascript">alert("你的用户名或者密码错误！");window.location.href="/login.php";</script>';
            exit;
        }
    }else{
		header("Content-type:text/html;charset=utf-8");
        echo '<script type="text/javascript">alert("请输入用户名和密码！");window.location.href="login.php";</script>';
        exit;
    }
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title;?> | <?=$siteTitle?></title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
	  <div id="login-page">
	  	<div class="container">
        <?php if($install):?>
          <form class="form-login" action="./login.php" method="post">
		        <h2 class="form-login-heading">系统初始化</h2>
		        <div class="login-wrap">
                <input type="text" class="form-control" name="username" placeholder="用户名" autofocus>
                <br>
                <input type="text" class="form-control" name="nickname" placeholder="昵称">
                <br>
                <input type="email" class="form-control" name="email" placeholder="邮箱">
                <br>
                <input type="password" class="form-control" name="passwd" placeholder="密码">
                <label class="checkbox">
                <span class="pull-left">
                        注意：此账户一旦设置即为超级管理员账户，不可修改！
                </span>
		        </label>
                <input type="hidden" value="true" name="install">
		        <button class="btn btn-theme btn-block" type="submit"> 安装系统</button>
		        </div>
          </form>
        <?php endif;
          if(!$install):?>
		      <form class="form-login" action="./login.php" method="post">
		        <h2 class="form-login-heading">登录系统</h2>
		        <div class="login-wrap">
		            <input type="text" class="form-control" name="username" placeholder="用户名" autofocus>
		            <br>
		            <input type="password" class="form-control" name="passwd" placeholder="密码">
                <br>
                <input type="hidden" value="true" name="login">
		            <button class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> 登录</button>
		            <hr>

		            <div class="login-social-link centered">
		            <p>or you can sign in via your social network</p>
		                <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>
		                <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>
		            </div>
		            <div class="registration">
		                Don't have an account yet?<br/>
		                <a class="" href="#">
		                    Create an account
		                </a>
		            </div>
		        </div>
          </form>
        <?php endif; ?>
	  	</div>
	  </div>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>
  </body>
</html>