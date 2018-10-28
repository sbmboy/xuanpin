<?php
require_once 'config.php';
if(!isset($_GET['id'])||$_GET['id']<0){
    echo '<script>alert("参数不正确");location.href="./show.php";</script>';
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
    <link href="assets/js/fancybox/jquery.fancybox.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/to-do.css">

    <script src="assets/js/jquery.js"></script>


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
	  $active = 'show';
	  include 'aside.php';?>
        <!--sidebar end-->

        <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
        <!--main content start-->
        <section id="main-content">
            <?php 
                $product = $lanthy->getProduct($_GET['id']);
            ?>
            <section class="wrapper">
          	<h3><i class="fa fa-info-circle"></i> 基本信息</h3>
          	
          	<!-- COMPLEX TO DO LIST -->			
              <div class="row mt">
                  <div class="col-md-12">
                      <section class="task-panel tasks-widget">
	                	<div class="panel-heading">
	                        <div class="pull-left"><h5><i class="fa fa-dropbox"></i> <?=$product['product_title']?></h5></div>
	                        <br>
	                 	</div>
                          <div class="panel-body">
                              <div class="task-content">

                                  <ul class="task-list">
                                      <li>
                                          <div class="task-title">
                                              <span class="task-title-sp"><?=$product['product_desc']?></span>
                                          </div>
                                      </li>
                                      <li>
                                          <div class="task-title">
                                                <span class="badge bg-warning" title="创建时间"><i class="fa fa-clock-o"> <?=format_date($product['product_posttime'])?></i></span>
                                                <span class="badge bg-info" title="图片数"><i class="fa fa-image"></i> <?=$product['product_image_counts']?></span>
                                                <span class="badge bg-theme" title="视频数"><i class="fa fa-video-camera"></i> <?=$product['product_video_counts']?></span>
                                                <span class="badge bg-success" title="其他文件"><i class="fa fa-file-text-o"></i> <?=$product['product_other_counts']?></span>  
                                                <span class="badge bg-info" title="创建者"><i class="fa fa-user"></i> <?=$product['product_user']?></span>
                                                <span class="badge bg-theme" title="下载数"><i class="fa fa-download"></i> <?=$product['product_downloadtimes']?></span>
                                          </div>
                                      </li>                      
                                  </ul>
                              </div>
                          </div>
                      </section>
                  </div><!-- /col-md-12-->
              </div><!-- /row -->
			
		</section>


            <section class="wrapper">
                <h3><i class="fa fa-image"></i> 图片</h3>
                <hr>
                <div class="row mt">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 desc">
                        <div class="project-wrapper">
                            <div class="project">
                                <div class="photo-wrapper">
                                    <div class="photo">
                                        <a class="fancybox" href="assets/img/portfolio/port04.jpg"><img class="img-responsive"
                                                src="assets/img/portfolio/port04.jpg" alt=""></a>
                                    </div>
                                    <div class="overlay"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-lg-4 -->

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 desc">
                        <div class="project-wrapper">
                            <div class="project">
                                <div class="photo-wrapper">
                                    <div class="photo">
                                        <a class="fancybox" href="assets/img/portfolio/port05.jpg"><img class="img-responsive"
                                                src="assets/img/portfolio/port05.jpg" alt=""></a>
                                    </div>
                                    <div class="overlay"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-lg-4 -->

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 desc">
                        <div class="project-wrapper">
                            <div class="project">
                                <div class="photo-wrapper">
                                    <div class="photo">
                                        <a class="fancybox" href="assets/img/portfolio/port06.jpg"><img class="img-responsive"
                                                src="assets/img/portfolio/port06.jpg" alt=""></a>
                                    </div>
                                    <div class="overlay"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-lg-4 -->
                </div><!-- /row -->

            </section>
            <!--/wrapper -->

            <section class="wrapper">
                <h3><i class="fa fa-video-camera"></i> 视频</h3>
                <hr>
                <div class="row mt">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 desc">
                        <div class="project-wrapper">
                            <div class="project">
                                <div class="photo-wrapper">
                                    <div class="photo">
                                        <a class="fancybox" href="assets/img/portfolio/port04.jpg"><img class="img-responsive"
                                                src="assets/img/portfolio/port04.jpg" alt=""></a>
                                    </div>
                                    <div class="overlay"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-lg-4 -->

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 desc">
                        <div class="project-wrapper">
                            <div class="project">
                                <div class="photo-wrapper">
                                    <div class="photo">
                                        <a class="fancybox" href="assets/img/portfolio/port05.jpg"><img class="img-responsive"
                                                src="assets/img/portfolio/port05.jpg" alt=""></a>
                                    </div>
                                    <div class="overlay"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-lg-4 -->

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 desc">
                        <div class="project-wrapper">
                            <div class="project">
                                <div class="photo-wrapper">
                                    <div class="photo">
                                        <a class="fancybox" href="assets/img/portfolio/port06.jpg"><img class="img-responsive"
                                                src="assets/img/portfolio/port06.jpg" alt=""></a>
                                    </div>
                                    <div class="overlay"></div>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-lg-4 -->
                </div><!-- /row -->

            </section>
            <!--/wrapper -->

            <section class="wrapper">
                <h3><i class="fa fa-file"></i> 其他</h3>
                <hr>
                <div class="row mt">
                  <div class="col-md-12">
                      <section class="task-panel tasks-widget">
	                	
                          <div class="panel-body">
                              <div class="task-content">
                                  <ul class="task-list">
                                      <li>
                                          
                                          <div class="task-title">
                                              <span class="task-title-sp">Dashgum - Admin Panel Theme</span>
                                              <span class="badge bg-theme">Done</span>
                                              <div class="pull-right hidden-phone">
                                                  <button class="btn btn-success btn-xs"><i class=" fa fa-check"></i></button>
                                                  <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                                  <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                                              </div>
                                          </div>
                                      </li>
                                      <li>
                                          
                                          <div class="task-title">
                                              <span class="task-title-sp">Extensive collection of plugins</span>
                                              <span class="badge bg-warning">Cool</span>
                                              <div class="pull-right hidden-phone">
                                                  <button class="btn btn-success btn-xs"><i class=" fa fa-check"></i></button>
                                                  <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                                  <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                                              </div>
                                          </div>
                                      </li>
                                      
                                                                           
                                  </ul>
                              </div>
                          </div>
                      </section>
                  </div><!-- /col-md-12-->
              </div>

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
    <script src="assets/js/fancybox/jquery.fancybox.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    
    <?php include 'footer.php';?>
</body>

</html>