<?php
if (!isset($_SESSION)) {
    session_start();
}
if(!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員"){
    header('Location: login');
    exit();
}
$title = "舍監";
require("layout/header.php");
?>

<div class="row">
    <div class="col-md-2 col-lg-3"></div>
    <div class="col-md-8 col-lg-6">
        <br>
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
        <h1 style="color: #5275e0;">新增舍監</h1>
        <form action="monitor_add_confirm.php" method="POST">
            <input type="hidden" name="identity" value="新增舍監">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">舍監學號</label>
                <div class="col-sm-10">
                    <input type="text" name="學號" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">舍監編號</label>
                <div class="col-sm-10">
                    <input type="text" name="舍監編號" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">管理房號</label>
                <div class="col-sm-10">
                    <input type="text" name="房間號碼" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">宿舍編號</label>
                <div class="col-sm-10">
                    <input type="text" name="宿舍編號" class="form-control" required>
                </div>
            </div>
            <input type="submit" value="新增" class="form-control btn btn-primary">
        </form>
    </div>
    <?php
    if (!isset($_SESSION['msg']) || $_SESSION['msg'] != "此學號已經是舍監了" || $_SESSION['msg'] != "所有欄位皆為必填")
        echo "<div id='刪除舍監' class='container tab-pane'>";
    else
        echo "<div id='刪除舍監' class='container tab-pane active'>";
    ?>
</div>
</div>
<div class="col-md-2 col-lg-3"></div>
</div>



<?php
require("layout/footer.php");
?>