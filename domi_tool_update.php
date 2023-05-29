<?php
if(!isset ($_SESSION))
{
session_start();
}
if(!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員"){
    header('Location: login');
    exit();
}
if(!isset($_GET['宿舍編號']))
{
    header('Location: domi_list');
    exit();
}
require('dbconnect.php');
$DomiID = $_GET['宿舍編號'];
$SQL = "SELECT 宿舍編號
      From 宿舍大樓
      WHERE  宿舍編號='$DomiID'";

$result = mysqli_query($link, $SQL);

if (mysqli_num_rows($result) == 0) {
    echo "<script type='text/javascript'>";
    echo "alert('資料錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_list'>";
    exit;
}
if(!isset($_GET['大樓設備']))
{
    header('Location: domi_tool_list?宿舍編號='.$DomiID);
    exit;
}
$ToolName=$_GET['大樓設備'];
$SQL = "SELECT 大樓設備
      From 宿舍大樓_大樓設備
      WHERE  宿舍編號='$DomiID' and 大樓設備='$ToolName'";

$result = mysqli_query($link, $SQL);

if (mysqli_num_rows($result) <= 0) {
    echo "<script type='text/javascript'>";
    echo "alert('資料錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=domi_tool_list?宿舍編號=".$DomiID."'>";
    exit;
}
$title = "大樓設備更新";
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
        <h1 style="color: #5275e0;">更新大樓設備</h1>
        <form action="domi_tool_update_confirm.php" method="POST">
            <input type="hidden" name="ToolName" value="<?php echo $ToolName?>">
            <input type="hidden" name="DID" value="<?php echo $DomiID?>">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">大樓編號</label>
                <div class="col-sm-10">
                <label class="col-sm-2 col-form-label"><?php echo $DomiID; ?></label>
                </div>  
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">大樓設備</label>
                <div class="col-sm-10">
                    <input type="text" name="大樓設備" class="form-control" required value="<?php echo $ToolName?>">
                </div>
            </div>
            <input type="submit" value="更新" class="form-control btn btn-primary">
        </form>
    </div>
</div>
<div class="col-md-2 col-lg-3"></div>
</div>



<?php
require("layout/footer.php");
?>