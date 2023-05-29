<?php
$title = "刪除舍監";
require("layout/header.php");
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
<form action="monitor_del_confirm.php" method="POST">
<h1 style="color: #5275e0;">刪除舍監</h1>
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
<input type="submit" value="刪除" class="form-control btn btn-primary">
</form>

<?php
require("layout/footer.php");
?>