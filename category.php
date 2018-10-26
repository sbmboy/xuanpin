<?php
require_once 'config.php';
if(isset($_GET['id'])&&$_GET['id']>0){
    $child = $_GET['id'];
}  else {
    $child = 0;
}
if(isset($_GET['cateid'])&&$_GET['cateid']>0){
    switch ($_GET['action']) {
        case 'del':
            $db = new SQLite3("DATA/{$dbname}",SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
            $sql="DELETE FROM hlong_category WHERE rowid = ".intval($_GET['cateid']);
            $result = $db->exec($sql);
            $db->close();
            if($result){
                echo '<script>alert("成功");</script>';
            }else{
                echo '<script>alert("失败");</script>';
            }
            break;
        default:
            echo '<script>alert("缺少参数");</script>';
            break;
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
    
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/to-do.css">

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
			
          	<!-- SORTABLE TO DO LIST -->
			
              <div class="row mt mb">
                  <div class="col-md-12">
                      <section class="task-panel tasks-widget">
	                	<div class="panel-heading">
	                        <div class="pull-left"><h5><i class="fa fa-folder-open"></i> <?php if($child) echo '子'; ?>分类列表</h5></div>
	                        <br>
	                 	</div>
                          <div class="panel-body">
                              <div class="task-content">
                                  <ul class="task-list">
                                        <?php
                                        $categories = $lanthy->getCategories($child);
                                        foreach($categories as $category):
                                        ?>
                                      <li class="list-primary">
                                          <div class="task-title">
                                              <i class=" fa fa-folder"> </i>
                                              <span class="task-title-sp"> <a href="?id=<?=$category['rowid']?>">- <?=$category['categoryname']?> -</a></span>
                                              <span class="badge bg-theme"><?=$category['dircounts']?></span>
                                              <span class="badge bg-important"><?=$category['filecounts']?></span>
                                              <div class="pull-right hidden-phone">
                                                  <a href="?id=<?=$child?>&cateid=<?=$category['rowid']?>&action=del" class="btn btn-danger btn-xs fa fa-trash-o" title="删除分类"></a>
                                              </div>
                                          </div>
                                      </li>
                                        <?php endforeach; ?>
                                  </ul>
                              </div>
                              <div class=" add-task-row">
                                <a class="btn btn-success btn-sm pull-left" href="addcategory.php?id=<?=$child?>">添加<?php if($child) echo '子'; ?>分类</a>
                              </div>
                          </div>
                      </section>
                  </div><!--/col-md-12 -->
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
