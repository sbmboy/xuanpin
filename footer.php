<!-- Modal for Search -->
<form action="./show.php" method="get">
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">输入关键词</h4>
            </div>
            <div class="modal-body">
                <input type="text" name="search" placeholder="搜索词" autocomplete="off" class="form-control placeholder-no-fix">
            </div>
            <div class="modal-footer centered">
                <input type="submit" class="btn btn-theme03" value="搜索">
            </div>
        </div>
    </div>
</div>
</form>
<!-- modal -->
<!-- Modal for passwd -->
<form action="./password.php" method="post">
<div aria-hidden="true" aria-labelledby="myPasswordLabel" role="dialog" tabindex="-1" id="myPassword" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">修改密码</h4>
            </div>
            <div class="modal-body">
                <input type="password" name="password" placeholder="输入新密码" autocomplete="off" class="form-control placeholder-no-fix">
            </div>
            <div class="modal-footer centered">
                <input type="submit" class="btn btn-theme03" value="确认修改">
            </div>
        </div>
    </div>
</div>
</form>
<!-- modal -->