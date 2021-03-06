<?php
require_once 'config.php';
/**
 * Upload Product
 */
if(isset($_POST['product_title'])){
    if($_POST['product_title']!=''){
        // 打开数据库
        $db = new SQLite3("DATA/{$dbname}",SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
        $db->exec("begin exclusive transaction"); // 缓存
        // 先获取分类的category_path
        $sql = "SELECT category_path FROM hlong_category WHERE rowid=".intval($_POST['category_id']);
        $category_path = $db->querySingle($sql);
        // 组合product_path
        $product_path = $category_path."/".md5($_POST['product_title']);
        if(!is_dir("FILES/{$product_path}")) mkdir("FILES/{$product_path}");
        // 获取product_tag
        preg_match_all('/./u', $_POST['product_title'], $product_tag_arr);
        $product_tag = implode(",",$product_tag_arr[0]);

        // 上传文件为空的情况
        if(empty($_FILES["files"]["tmp_name"][0])){
            $image_counts = 0;
            $video_counts = 0;
            $other_counts = 0;
        }else{
            // 计算各种类型文件数量
            $file_type=implode(",",$_FILES["files"]["type"]);
            $image_counts = substr_count($file_type,"image"); // image
            $video_counts = substr_count($file_type,"video"); // video
            $other_counts = count($_FILES["files"]["type"])-$image_counts-$video_counts;
        }

        // 更新products表
        $sql="INSERT INTO hlong_products (\"product_category_id\", \"product_title\", \"product_path\",\"product_tag\", \"product_desc\", \"product_posttime\", \"product_user\", \"product_image_counts\", \"product_video_counts\", \"product_other_counts\", \"product_downloadtimes\") 
        VALUES ('".intval($_POST['category_id'])."','".$db->escapeString($_POST['product_title'])."','".$db->escapeString($product_path)."','".$db->escapeString($product_tag)."','".$db->escapeString($_POST['product_desc'])."',".time().",'".$_SESSION['loginStatus']['nickname']."',{$image_counts},{$video_counts},{$other_counts},0)";
        $db->exec($sql);

        // 目录产品+1
        $sql="UPDATE hlong_category SET category_products_counts = category_products_counts+1 WHERE rowid =".intval($_POST['category_id']);
        $db->exec($sql);

        // 上传文件不为空的情况
        if(!empty($_FILES["files"]["tmp_name"][0])){
            // 获取product_id
            $sql="SELECT rowid FROM hlong_products ORDER BY rowid DESC LIMIT 0,1";
            // $sql="SELECT last_insert_rowid() FROM hlong_products";
            $product_id = $db->querySingle($sql);
            // 更新filesinfo表
            for($i=0;$i<count($_FILES["files"]["type"]);$i++){
                // 保存文件
                $file_title = $_FILES["files"]["name"][$i];
                $file_path = $product_path.'/'.$file_title;
                $file_size = $_FILES["files"]["size"][$i];
                $file_type = $_FILES["files"]["type"][$i];        
                $sql = "INSERT INTO hlong_filesinfo (\"file_product_id\", \"file_title\", \"file_path\", \"file_size\", \"file_type\", \"file_posttime\",\"file_author\", \"file_downloadtimes\") 
                VALUES({$product_id},'".$db->escapeString($file_title)."','{$file_path}',{$file_size},'{$file_type}',".time().",'".$_SESSION['loginStatus']['nickname']."',0)";
                move_uploaded_file($_FILES["files"]["tmp_name"][$i], "FILES/".$file_path);
                $db->exec($sql);
            }
        }
        $db->exec("end transaction");// 缓存
        // 关闭数据库
        $db->close();
        echo '<script>alert("成功");location.href="./upload.php?id='.$_POST['category_id'].'"</script>';
    }else{
        echo '<script>alert("产品名不能为空");</script>';
    }
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

                <!-- BASIC FORM ELELEMNTS -->
                <div class="row mt">
                    <div class="col-lg-12">
                        <div class="form-panel">
                            <h4 class="mb"><i class="fa fa-inbox"></i> 上传资料</h4>
                            <form class="form-horizontal style-form" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="product_title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">描述</label>
                                    <div class="col-sm-10">
                                        <textarea name="product_desc" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">资料</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="files[]" class="form-control" multiple>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="category_id" value="<?=$_GET['id']?>">
                                        <input type="submit" class="btn btn-primary" value="上传">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- col-lg-12-->
                </div><!-- /row -->

            </section>
            <!--/wrapper -->
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