<?php
//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || ($_SESSION['login_identity'] != "系統管理員" && $_SESSION['login_identity'] != "舍監")) {
    header('Location: login');
    exit;
}

$title = "違規登記";
require('layout/header.php');
?>

<br>
<div class="row">
    <div class="col-md-2 col-lg-3"></div>
    <div class="col-md-8 col-lg-6">
        <h1>違規登記</h1>
        <form action="violate_confirm.php" method="POST">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">學號</label>
                <div class="col-sm-10">
                    <input type="text" name="學號" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">違規事項</label>
                <div class="col-sm-10">
                    <input type="text" name="違規事項" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">違規日期</label>
                <div class="col-sm-10">
                    <input type="date" name="違規日期" class="form-control" required>
                </div>
            </div>
            <input type="submit" value="確認登記" class="form-control btn btn-primary">
        </form>
        <br>
        <!-- 警告內容：成功、失敗 -->
        <?php
        if (isset($_SESSION['msg'])) {
            if ($_SESSION['msg'] == "違規登記成功！") {
                print <<<EOT
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                    <div>
                        {$_SESSION['msg']}
                    </div>
                </div>
    EOT;
            } else {
                print <<<EOT
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                        {$_SESSION['msg']}
                    </div>
    EOT;
            }
            unset($_SESSION['msg']);
        }
        ?>
        <br>&nbsp;
    </div>
    <div class="col-md-2 col-lg-3"></div>
</div>

<?php
require('layout/footer.php');
?>