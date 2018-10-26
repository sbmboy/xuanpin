<?php
require_once 'config.php';
/**
 * Add category
 */
if(isset($_POST['cate_name'])&&!empty($_POST['cate_name'])){
    $db = new SQLite3("DATA/{$dbname}",SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
    $sql="INSERT INTO hlong_category (\"categoryname\",\"slug\",\"father\",\"dircounts\",\"filecounts\",\"remark\") VALUES ('".$db->escapeString($_POST['cate_name'])."','".$db->escapeString(md5($_POST['cate_name']))."','".$db->escapeString($_POST['father'])."',0,0,'".$db->escapeString($_POST['remark'])."')";
    $result = $db->exec($sql);
    $sql="UPDATE hlong_category SET dircounts = dircounts+1 WHERE rowid =".intval($_POST['father']);
    $db->exec($sql);
    $db->close();
    if($result){
        if(!is_dir('FILES/'.md5($_POST['cate_name']))) mkdir('FILES/'.md5($_POST['cate_name']));
        echo '<script>alert("成功");location.href="category.php?id='.intval($_POST['father']).'";</script>';
    }else{
        echo '<script>alert("失败");</script>';
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
      $active = 'category';
      include 'aside.php';?>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-cogs"></i> 分类管理</h3>
          	
          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                  	  <h4 class="mb"><i class="fa fa-sitemap"></i> 添加分类</h4>
                      <form class="form-horizontal style-form" method="post">
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">分类名称</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="cate_name">
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
                                  <input type="hidden" name="father" value="<?php if(isset($_GET['id'])) echo $_GET['id']; else echo '0'; ?>">
                                  <input type="submit" class="btn btn-primary" value="添加分类">
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


  </body>
</html>
