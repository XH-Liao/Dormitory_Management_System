<?php
$title = "大樓新增";

require("layout/header.php");
if(!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員"){
    header('Location: login');
    exit();
}

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
        <h1 style="color: #5275e0;">新增大樓</h1>
        <form action="domitory_confirm.php" method="POST">
            <input type="hidden" name="identity" value="新增大樓">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">大樓名稱</label>
                <div class="col-sm-10">
                    <input type="text" name="大樓名稱" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">房間住宿費用</label>
                <div class="col-sm-10">
                    <input type="text" name="費用" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">房間數</label>
                <div class="col-sm-10">
                    <input type="text" name="房間數" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">大樓編號</label>
                <div class="col-sm-10">
                    <input type="text" name="大樓編號" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">性別</label>
            <div class="col-sm-10">
                <select class="form-select" name="性別" aria-label="Default select example">
                    <option selected disabled>請選擇</option>
                    <option value="男">男</option>
                    <option value="女">女</option>
                </select>
            </div>
            </div>
            <input type="submit" value="新增" class="form-control btn btn-primary">
        </form>
    </div>
</div>
<div class="col-md-2 col-lg-3"></div>
</div>



<?php
require("layout/footer.php");
?>