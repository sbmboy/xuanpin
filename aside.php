<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <p class="centered"><a data-toggle="modal" href="#myPassword" title="修改密码"><img src="<?='http://www.gravatar.com/avatar/'.md5($_SESSION['loginStatus']['email']).'';?>"
                        class="img-circle" width="60"></a></p>
            <h5 class="centered">
                <?=$_SESSION['loginStatus']['nickname']?>
            </h5>

            <li class="mt">
                <a <?php if($active=='home') echo 'class="active"'; ?> href="./index.php">
                    <i class="fa fa-dashboard"></i>
                    <span>控制台</span>
                </a>
            </li>

            <li>
                <a <?php if($active=='show') echo 'class="active"'; ?> href="./show.php">
                    <i class="fa fa-archive"></i>
                    <span>所有产品</span>
                </a>
            </li>

            <li>
                <a <?php if($active=='category') echo 'class="active"'; ?> href="./category.php">
                    <i class="fa fa-sitemap"></i>
                    <span>分类管理</span>
                </a>
            </li>

            <li>
                <a <?php if($active=='upload') echo 'class="active"'; ?> href="./upload.php">
                    <i class="fa fa-upload"></i>
                    <span>上传产品</span>
                </a>
            </li>

            <li class="sub-menu">
                <a <?php if($active=='user') echo 'class="active"'; ?> href="./user.php">
                    <i class="fa fa-users"></i>
                    <span>用户管理</span>
                </a>
            </li>

            

        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>