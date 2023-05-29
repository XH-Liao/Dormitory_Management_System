<?php
//Check："系統管理員"才可使用本頁面、Check：有GET參數
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}
if(!isset($_GET['編號']) ||  !isset($_GET['學號']))
{
    header('Location: moni_list');
    exit;
}
$StuID = $_GET['學號'];
$MonitorID = $_GET['編號'];
require('dbconnect.php');
$SQL = "SELECT 學號,舍監編號
      From 學生
      WHERE  學號='$StuID' and 舍監編號='$MonitorID'";

$result = mysqli_query($link, $SQL);

if (mysqli_num_rows($result) == 0) {
    echo "<script type='text/javascript'>";
    echo "alert('資料錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=moni_list'>";
    exit;
}

$title = "註冊";
require('layout/header.php');




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
        <h1>修改舍監資訊</h1>
        <form action="monitor_update_confirm.php" method="POST">
            <input type="hidden" name="SID" value="<?php echo $StuID ?>">
            <input type="hidden" name="MID" value="<?php echo $MonitorID ?>">

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">舍監學號</label>
                <div class="col-sm-10">
                    <label class="col-sm-2 col-form-label"><?php echo $StuID; ?></label>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">舍監編號</label>
                <div class="col-sm-10">
                    <input type="text" name="舍監編號" class="form-control" required value="<?php echo $MonitorID ?>">
                </div>
            </div>
            <input type="submit" value="確認修改" class="form-control btn btn-primary">
        </form>

    </div>
    <div class="col-md-2 col-lg-3"></div>
</div>


<?php
require('layout/footer.php');
?>