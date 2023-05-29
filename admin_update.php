<?php
//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_account'] != "admin") {
    header('Location: login');
    exit;
}

//Check：有GET參數
$Account = $_GET['Account'];
if ($Account == null) {
    header('Location: admin_list');
    exit;
}

if($Account=="admin"){
    echo "<script> alert('Admin資料不允許修改！'); </script>";
    echo '<meta http-equiv="refresh" content="0; url=admin_list">';
    exit;
}

$title = "修改管理員資訊";
require('layout/header.php');

require('dbconnect.php');
//查詢學生原資料
$SQL = "SELECT 姓名, 生日
        FROM 系統管理員
        WHERE Account='$Account'";
$result = mysqli_query($link, $SQL);
if (mysqli_num_rows($result) <= 0) {
    echo "<br><h3 id='h1_center'>Error</h3>";
    exit;
}
$row = mysqli_fetch_assoc($result);
?>


<div class="row">
    <div class="col-md-2 col-lg-3"></div>
    <div class="col-md-8 col-lg-6">
        <br>
        <h1>修改管理員資訊</h1>
        <!-- 警告內容：成功、失敗 -->
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
        <form action="admin_update_confirm.php" method="POST">
            <input type="hidden" name="Account" value="<?php echo $Account; ?>">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Account</label>
                <div class="col-sm-10">
                    <label class="col-form-label"><?php echo $Account; ?></label>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">姓名</label>
                <div class="col-sm-10">
                    <input type="text" name="姓名" class="form-control" required value="<?php echo $row['姓名'] ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">生日</label>
                <div class="col-sm-10">
                    <input type="date" name="生日" class="form-control" required value="<?php echo $row['生日'] ?>">
                </div>
            </div>
            <input type="submit" value="確認修改" class="form-control btn btn-primary">
        </form>
        <br>&nbsp;
    </div>
    <div class="col-md-2 col-lg-3"></div>
</div>


<?php
require('layout/footer.php');
?>