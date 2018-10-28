<?php
require_once 'config.php';
/**
 * Add user
 */
if(isset($_POST['username'])){
    if(!empty($_POST['username'])&&!empty($_POST['password'])){
        $db = new SQLite3("DATA/{$dbname}",SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);

        $sql="INSERT INTO hlong_user (\"user_nicename\", \"user_username\", \"user_password\", \"user_email\", \"user_logintime\", \"user_group\", \"user_auth\", \"user_status\", \"user_remark\") 
        VALUES ('".$db->escapeString($_POST['nickname'])."','".$db->escapeString($_POST['username'])."','".$db->escapeString(md5($_POST['password'].$siteTitle))."','".$db->escapeString($_POST['email'])."',Null,Null,'".$db->escapeString($_POST['auth'])."','enable','".$db->escapeString($_POST['remark'])."')";
        $result = $db->exec($sql);
        $db->close();
        if($result){
            echo '<script>alert("成功");location.href="user.php";</script>';
        }else{
            echo '<script>alert("失败");</script>';
        }
    }else{
        echo '<script>alert("请设置用户名和密码");</script>';
    }
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$siteSubtitle?>|<?=$siteTitle?></title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css" />
        
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

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <?php include 'header.php';?>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <?php 
      $active = 'user';
      include 'aside.php';?>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-cogs"></i> 用户管理</h3>
          	
          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                  	  <h4 class="mb"><i class="fa fa-user"></i> 添加用户</h4>
                      <form class="form-horizontal style-form" method="post">
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">用户名</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="username">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">密码</label>
                              <div class="col-sm-10">
                                  <input type="password" class="form-control" name="password">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">昵称</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="nickname">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">邮箱</label>
                              <div class="col-sm-10">
                                  <input type="email" class="form-control" name="email">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">权限</label>
                              <div class="col-sm-10">
                              <select class="form-control" name="auth">
                                <option value="5">普通用户</option>
                                <option value="8">管理员</option>
                                </select>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">备注信息</label>
                              <div class="col-sm-10">
                                  <textarea name="remark" class="form-control"></textarea>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label"></label>
                              <div class="col-sm-10">
                                  <input type="submit" class="btn btn-primary" value="添加用户">
                              </div>
                          </div>
                      </form>
                  </div>
          		</div><!-- col-lg-12-->      	
          	</div><!-- /row -->
 
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2018 &copy; Lanthy.com. 蓝悉科技强力驱动。
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

<?php include 'footer.php';?>
  </body>
</html>
