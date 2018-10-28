<?php
require_once 'config.php';
/**
 * Upload Product
 */
if(isset($_FILES["files"]["tmp_name"][0])){
    if(!empty($_FILES["files"]["tmp_name"][0])){
        // 计算各种类型文件数量
        $file_type=implode(",",$_FILES["files"]["type"]);
        $image_counts = substr_count($file_type,"image"); // image
        $video_counts = substr_count($file_type,"video"); // video
        $other_counts = count($_FILES["files"]["type"])-$image_counts-$video_counts;

        // 打开数据库
        $db = new SQLite3("DATA/{$dbname}",SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
        $db->exec("begin exclusive transaction"); // 缓存
        // 更新products表的资源类型数据
        $sql = "UPDATE hlong_products SET product_image_counts=product_image_counts+{$image_counts},product_video_counts=product_video_counts+{$video_counts},product_other_counts=product_other_counts+{$other_counts} WHERE rowid=".intval($_POST['product_id']);
        $db->exec($sql);
        // 获取文件夹路径
        $sql="SELECT product_path FROM hlong_products WHERE rowid=".intval($_POST['product_id']);
        $product_path = $db->querySingle($sql);
        $product_id = intval($_POST['product_id']);
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
        $db->exec("end transaction");// 缓存
        // 关闭数据库
        $db->close();
        echo '<script>alert("成功");location.href="./download.php?id='.$_POST['product_id'].'"</script>';
    }else{
        echo '<script>alert("上传文件为空");</script>';
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
                <h3><i class="fa fa-upload"></i> 上传文件</h3>

                <!-- BASIC FORM ELELEMNTS -->
                <div class="row mt">
                    <div class="col-lg-12">
                        <div class="form-panel">
                            <h4 class="mb"><i class="fa fa-inbox"></i> 更新资料</h4>
                            <form class="form-horizontal style-form" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">资料</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="files[]" class="form-control" multiple>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="product_id" value="<?=$_GET['id']?>">
                                        <input type="submit" class="btn btn-primary" value="上传">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- col-lg-12-->
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