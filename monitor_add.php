<?php
$title = "新增舍監";
require("layout/header.php");
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}
?>

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
<form action="monitor_add_confirm.php" method="POST">
<h1 style="color: #5275e0;">新增舍監</h1>

<div class="mb-3 row">
    <label class="col-sm-2 col-form-label">舍監學號</label>
    <div class="col-sm-10">
        <input type="text" name="學號" class="form-control" required>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-2 col-form-label">舍監編號</label>
    <div class="col-sm-10">
        <input type="text" name="編號" class="form-control" required>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-2 col-form-label">管理房號</label>
    <div class="col-sm-10">
        <input type="text" name="房號" class="form-control" required>
    </div>
</div>
<input type="submit" value="新增" class="form-control btn btn-primary">
</form>

<?php
require("layout/footer.php");
?>