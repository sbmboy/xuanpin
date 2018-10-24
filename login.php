<?php
/**
 * 安装登录
 *
 */
session_start();
$siteTitle='蓝悉科技'; // 站点标题
$siteSubtitle='选品管理系统'; // 站点副标题
if(!file_exists('DATA/messagecloud')){
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
	if(!extension_loaded('sqlite3')) die("检查php.in文件是否支持sqlite3数据库！");
    $db = new SQLite3("DATA/messagecloud",SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
	$db->exec("begin exclusive transaction");
	// 创建user表
    $db->exec("CREATE TABLE \"hlong_user\" (
  		\"username\" varchar,  /*用户名*/
  		\"nickname\" varchar,  /*昵称*/
  		\"passwd\" varchar,    /*密码*/
  		\"email\" varchar,     /*邮箱*/
  		\"lastlogin\" INTEGER, /*最后登录时间*/
  		\"auth\" INTEGER,      /*权限*/
  		\"group\" varchar,     /*所属组*/
  		\"tables\" varchar,    /*数据表*/
  		\"sidebar\" varchar,   /*可访问数据表*/
  		\"remark\" TEXT)       /*备注信息*/
		");
    $db->exec("CREATE UNIQUE INDEX user_username on hlong_user (username)");
    $passwd=md5($passwd.$siteTitle);
    $username=$db->escapeString($username);
    $nickname=$db->escapeString($nickname);
    $passwd=$db->escapeString($passwd);
    $email=$db->escapeString($email);
		// 写入超级管理员
    $sql="insert into hlong_user values ('{$username}','{$nickname}','{$passwd}','{$email}',NULL,9,NULL,NULL,NULL,'超级管理员')";
    $db->exec($sql);
    // 创建table表
    $db->exec("CREATE TABLE \"hlong_table\" (
  		\"tablename\" varchar,    /*名称*/
      \"description\" varchar,  /*描述*/
  		\"structure\" varchar,    /*字段*/
  		\"users\" TEXT,           /*用户*/
  		\"addtime\" INTEGER)      /*添加时间*/
		");
    $db->exec("CREATE UNIQUE INDEX table_tablename on hlong_table (tablename)");
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
		$db=new SQLite3("DATA/messagecloud",SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
		$sql="SELECT rowid,* FROM `hlong_user` WHERE username = '{$_POST['username']}' AND passwd = '".md5($_POST['passwd'].$siteTitle)."'";
		$result=$db->query($sql);
		$row=$result->fetchArray(SQLITE3_ASSOC);
		if($row){
			if($row['group']=='Disabled'){
              $result->finalize();
              unset($result);
              $db->close();
              header("Content-type:text/html;charset=utf-8");
              echo '<script type="text/javascript">alert("对不起 '.$row['username'].'，你的账户已经被禁用，请联系管理员。");window.location.href="/login.php";</script>';
              exit;
      }else{
    				$_SESSION['loginStatus']=array(
            'username' => $row['username'],
            'email' => $row['email'],
  					'nickname' => $row['nickname'],
            'auth' => $row['auth'],
            'tables' => $row['tables'],
            'sidebar' => $row['sidebar'],
  					'status' =>true,
  					'loginTime' => time(),
			      );
            $sql="UPDATE \"hlong_user\" SET \"lastlogin\" = '".time()."' WHERE \"username\" = '{$row['username']}'";
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
		        <h2 class="form-login-heading">Install now</h2>
		        <div class="login-wrap">
                <input type="text" class="form-control" name="username" placeholder="User Name" autofocus>
                <br>
                <input type="text" class="form-control" name="nickname" placeholder="Nick name">
                <br>
		            <input type="email" class="form-control" name="email" placeholder="Email">
		            <br>
		            <input type="password" class="form-control" name="passwd" placeholder="Password">
                <label class="checkbox">
		                <span class="pull-left">
		                     注意：此账户一旦设置即为超级管理员账户，不可修改！
		                </span>
		            </label>
                <input type="hidden" value="true" name="install">
		            <button class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i>INSTALL</button>
		        </div>
          </form>
        <?php endif;
          if(!$install):?>
		      <form class="form-login" action="./login.php" method="post">
		        <h2 class="form-login-heading">sign in now</h2>
		        <div class="login-wrap">
		            <input type="text" class="form-control" name="username" placeholder="Username" autofocus>
		            <br>
		            <input type="password" class="form-control" name="passwd" placeholder="Password">
                <br>
                <input type="hidden" value="true" name="login">
		            <button class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
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