<?php

//Check：若已登入，跳轉回首頁
session_start();
if(isset($_SESSION['login_identity'])){
    header('Location: /DB_FinalProject');
    exit();
}

$title = "登入";
require("layout/header.php");
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
        <form action="login_confirm.php" method="POST">
            <h1 style="color: #5275e0;">登入</h1>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">帳號</label>
                <div class="col-sm-10">
                    <input type="text" name="帳號" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">密碼</label>
                <div class="col-sm-10">
                    <input type="password" name="密碼" class="form-control" required placeholder="預設密碼：Nuk + 生日(yyyy-mm-dd)">
                </div>
            </div>
            <input type="submit" value="登入" class="form-control btn btn-primary">
        </form>
    </div>
    <div class="col-md-2 col-lg-3"></div>
</div>

<?php
require("layout/footer.php");
?>