<?php
//Check："系統管理員"才可使用本頁面
session_start();
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}

//Check：有GET參數
$Account = $_GET['老師編號'];
if ($Account == null) {
    header('Location: teacher_list');
    exit;
}

$title = "修改老師資訊";
require('layout/header.php');

require('dbconnect.php');
//查詢老師原資料
$SQL = "SELECT 姓名, 生日, 班級編號
        FROM 老師
        WHERE 老師編號='$Account'";
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
        <h1>修改老師資訊</h1>
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
        <form action="teacher_update_confirm.php" method="POST">
            <input type="hidden" name="Account" value="<?php echo $Account; ?>">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">老師編號</label>
                <div class="col-sm-10">
                    <label class="col-form-label"><?php echo $Account; ?></label>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">指導班級</label>
                <div class="col-sm-10">
                    <input type="text" name="班級" class="form-control" required value="<?php echo $row['班級編號'] ?>">
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