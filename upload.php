<?php
require_once 'config.php';
if(isset($_GET['id'])&&$_GET['id']>0){
    $child = $_GET['id'];
}  else {
    $child = 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?=$siteSubtitle?>|
        <?=$siteTitle?>
    </title>

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

    <section id="container">
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
      $active = 'upload';
      include 'aside.php';?>
        <!--sidebar end-->

        <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <h3><i class="fa fa-upload"></i> 上传产品</h3>

                <!-- SORTABLE TO DO LIST -->

                <div class="row mt mb">
                    <div class="col-md-12">
                        <section class="task-panel tasks-widget">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h5><i class="fa fa-folder-open"></i> 选择
                                        <?php if($child) echo '子'; ?>分类</h5>
                                </div>
                                <br>
                            </div>
                            <div class="panel-body">
                                <div class="task-content">
                                    <ul class="task-list">
                                        <?php if($child):
                                            $father = $lanthy->getCategory($child);
                                        ?>
                                        <li>
                                            <div class="task-title">
                                                <i class=" fa fa-share"> </i>
                                                <span class="task-title-sp"><a href="?id=<?=$father['category_father_id']?>">
                                                        - 上级目录 -</a></span>
                                            </div>
                                        </li>
                                        <?php endif; ?>

                                        <?php
                                    $categories = $lanthy->getCategories($child);
                                    foreach($categories as $category):
                                    ?>
                                        <li class="list-primary">
                                            <div class="task-title">
                                                <i class=" fa fa-folder<?php if($child) echo '-open'?>"> </i>
                                                <span class="task-title-sp"> <a href="?id=<?=$category['rowid']?>"
                                                        title="<?=$category['category_desc']?>">-
                                                        <?=$category['category_name']?> -</a></span>
                                                <span class="badge bg-theme" title="目录数">
                                                    <?=$category['category_child_counts']?></span>
                                                <span class="badge bg-important" title="文件数">
                                                    <?=$category['category_products_counts']?></span>
                                                <div class="pull-right hidden-phone">
                                                    <a href="uploadproduct.php?id=<?=$category['rowid']?>" class="btn btn-primary btn-xs fa fa-upload"
                                                        title="上传到分类"></a>
                                                </div>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>
                                        <?php
                                    $products = $lanthy->getProducts($child);
                                    foreach($products as $product):
                                    ?>
                                        <li class="list-primary">
                                            <div class="task-title">
                                                <i class=" fa fa-copy"> </i>
                                                <span class="task-title-sp"> -
                                                    <?=$product['product_title']?> -</span>
                                                <span class="badge bg-info" title="图片数"><i class="fa fa-image"></i> <?=$product['product_image_counts']?></span>
                                                <span class="badge bg-theme" title="视频数"><i class="fa fa-video-camera"></i> <?=$product['product_video_counts']?></span>
                                                <span class="badge bg-success" title="其他文件"><i class="fa fa-file-text-o"></i> <?=$product['product_other_counts']?></span>    
                                                <div class="pull-right hidden-phone">
                                                    <a href="download.php?id=<?=$product['rowid']?>" class="btn btn-warning btn-xs fa fa-download"
                                                        title="下载产品资料"></a>
                                                    <a href="updateproduct.php?id=<?=$product['rowid']?>" class="btn btn-primary btn-xs fa fa-upload"
                                                        title="上传产品资料"></a>

                                                </div>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>




                                    </ul>
                                </div>
                                <div class=" add-task-row">
                                    <?php if($child): ?><a class="btn btn-success btn-sm pull-left" href="uploadproduct.php?id=<?=$child?>">上传产品</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!--/col-md-12 -->
                </div><!-- /row -->

            </section>
            <! --/wrapper -->
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