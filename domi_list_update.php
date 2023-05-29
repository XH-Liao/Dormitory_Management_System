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
$title = "大樓更新";
require("layout/header.php");
require('dbconnect.php');
$DomiID=$_GET['宿舍編號'];
$SQL="SELECT 宿舍編號,大樓名稱,房間住宿費用,房間數
      from 宿舍大樓
      where 宿舍編號='$DomiID'
      ";
$result = mysqli_query($link, $SQL);
if(mysqli_num_rows($result) <= 0){
    echo "<br><h3 id='h1_center'>Error</h3>";
    exit;
}
$row = mysqli_fetch_assoc($result);
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
        <h1 style="color: #5275e0;">更新宿舍大樓</h1>
        <form action="domi_update_confirm.php" method="POST">
            <input type="hidden" name="DName" value="<?php echo $row['大樓名稱']?>">
            <input type="hidden" name="Price" value="<?php echo $row['房間住宿費用']?>">
            <input type="hidden" name="RoomNum" value="<?php echo $row['房間數']?>">
            <input type="hidden" name="DID" value="<?php echo $DomiID?>">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">大樓編號</label>
                <div class="col-sm-10">
                <label class="col-sm-2 col-form-label"><?php echo $DomiID; ?></label>
                </div>  
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">大樓名稱</label>
                <div class="col-sm-10">
                    <input type="text" name="大樓名稱" class="form-control" required value="<?php echo $row['大樓名稱']?>">
                </div>
            </div>
            <!--<div class="mb-3 row">
                <label class="col-sm-2 col-form-label">房間數</label>
                <div class="col-sm-10">
                    <input type="text" name="房間數" class="form-control" required value="<?php echo $row['房間數']?>">
                </div>
            </div>-->
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">房間住宿費用</label>
                <div class="col-sm-10">
                     <input type="text" name="費用" class="form-control" required value="<?php echo $row['房間住宿費用']?>">
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