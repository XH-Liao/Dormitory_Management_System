<?php
if(!isset ($_SESSION))
{
session_start();
}
if (!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "系統管理員" ) {
    header('Location: login');
    exit;
}
if(!isset($_GET['宿舍編號']))
{
    header('Location: domi_list');
    exit;
}
$DomiID = $_GET['宿舍編號'];
require('dbconnect.php');
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
if(!isset($_GET['房間號碼']))
{
    header('Location: room_list?宿舍編號'.$DomiID);
    exit();
}
$RoomID = $_GET['房間號碼'];
$SQL="SELECT 房間號碼
      FROM 宿舍房間
      WHERE 宿舍編號='$DomiID' and 房間號碼='$RoomID'
      ";
$result=mysqli_query($link,$SQL);
if (mysqli_num_rows($result) == 0) {
    echo "<script type='text/javascript'>";
    echo "alert('資料錯誤')";
    echo "</script>";
    echo "<meta http-equiv='Refresh' content='0; url=room_list?宿舍編號=".$DomiID."'>";
    exit;
}   
$title = "房間舍監更新";
require("layout/header.php");


$SQL="SELECT 舍監編號
      From 舍監
      ";
$result=mysqli_query($link,$SQL);
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
        <h1 style="color: #5275e0;">設定<?php echo $DomiID.$RoomID; ?>舍監</h1>
        <form action="room_edit_moni_confirm.php" method="POST">
            <input type="hidden" name="RID" value="<?php echo $RoomID ?>">
            <input type="hidden" name="DID" value="<?php echo $DomiID ?>">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">舍監編號</label>
                <div class="col-sm-10">
                <select class="form-select" name="舍監編號" aria-label="select">
                <option selected disabled>請選擇</option>
                <?php
                while($row=mysqli_fetch_assoc($result))
                {
                    echo "<option value=".$row['舍監編號'].">".$row['舍監編號']."</option>";
                }
                echo "<option value=清空>清空編號</option>";
                ?>
                </select>
                </div>
            </div>
            <input type="submit" value="設定" class="form-control btn btn-primary">
        </form>
    </div>
</div>
<div class="col-md-2 col-lg-3"></div>
</div>


<?php
require("layout/footer.php");
?>