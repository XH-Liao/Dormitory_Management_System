<?php
if(!isset ($_SESSION))
{
session_start();
}
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員") {
    header('Location: login');
    exit;
}
if(!isset($_GET['宿舍編號']))
{
    header('Location: domi_list');
    exit;
}
require('dbconnect.php');
$DomiID = $_GET['宿舍編號'];
$SQL="SELECT 宿舍編號
      FROM 宿舍大樓
      WHERE 宿舍編號='$DomiID'
      ";
$result=mysqli_query($link,$SQL);
if (mysqli_num_rows($result) == 0) {
    echo "<script type='text/javascript'>";
    echo "alert('資料錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
    exit;
} 
$title = "新增房間";
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
        <h1 style="color: #5275e0;">新增房間</h1>
        <form action="room_confirm.php" method="POST">
            <input type="hidden" name="DID" value="<?php echo $DomiID?>">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">大樓編號</label>
                <div class="col-sm-10">
                    <label class="col-sm-2 col-form-label"><?php echo $DomiID; ?></label>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">房間編號</label>
                <div class="col-sm-10">
                    <input type="text" name="房間編號" class="form-control" required>
                </div>
            </div>
            
            <input type="submit" value="新增" class="form-control btn btn-primary">
        </form>
    </div>
</div>
</div>

<?php
require("layout/footer.php");
?>