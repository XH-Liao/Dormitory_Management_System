<?php
//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity'])) {
    header('Location: login');
    exit;
}

$title = "密碼修改";
require('layout/header.php');
?>

<br>
<div class="row">
    <div class="col-md-2 col-lg-3"></div>
    <div class="col-md-8 col-lg-6">
        <!-- 警告失敗內容 -->
        <?php
        if (isset($_SESSION['msg'])) {
            print <<<EOT
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    {$_SESSION['msg']}
                </div>
                </div>
EOT;
            unset($_SESSION['msg']);
        }
        ?>
        <h1>密碼修改</h1>
        <form action="alter_password_confirm.php" method="POST">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">原密碼</label>
                <div class="col-sm-10">
                    <input type="password" name="原密碼" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">新密碼</label>
                <div class="col-sm-10">
                    <input type="password" name="新密碼" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">確認密碼</label>
                <div class="col-sm-10">
                    <input type="password" name="確認密碼" class="form-control" required>
                </div>
            </div>
            <input type="submit" value="確認修改密碼" class="form-control btn btn-primary">
        </form>
        <br>&nbsp;
    </div>
    <div class="col-md-2 col-lg-3"></div>
</div>

<?php
require('layout/footer.php');
?>