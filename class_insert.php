<?php
//Check："系統管理員"才可使用本頁面
session_start();
if(!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員"){
    header('Location: login');
    exit();
}

$title = "新增班級";
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
        <h1 style="color: #5275e0;">新增班級</h1>
        <form action="class_insert_confirm.php" method="POST">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">班級編號</label>
                <div class="col-sm-10">
                    <input type="text" name="班級" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">老師編號1</label>
                <div class="col-sm-10">
                    <input type="text" name="老師1" class="form-control">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">老師編號2</label>
                <div class="col-sm-10">
                    <input type="text" name="老師2" class="form-control">
                </div>
            </div>
            <input type="submit" value="新增班級" class="form-control btn btn-primary">
        </form>
    </div>
</div>
</div>
<div class="col-md-2 col-lg-3"></div>
</div>



<?php
require("layout/footer.php");
?>