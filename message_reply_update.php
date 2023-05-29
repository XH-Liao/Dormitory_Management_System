<?php
session_start();
require('dbconnect.php');

$title = "回覆修改";
require('layout/header.php');

//HTTP-GET
$message_No = $_GET['No'];
if($message_No == null){
    echo "<script type='text/javascript'>";
    echo "alert('Error!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
    exit;
}

//Check：有此留言、查詢此留言回覆
$SQL = "SELECT 回覆內容, 舍監編號
        FROM 留言
        WHERE No=$message_No";
$result = mysqli_query($link, $SQL);
if(mysqli_num_rows($result) != 1){
    echo "<script type='text/javascript'>";
    echo "alert('Error!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message'/>";
    exit;
}

//Check：必須是回覆者本人才可修改
$row = mysqli_fetch_assoc($result);
if(!isset($_SESSION['login_identity']) || $row["舍監編號"] != $_SESSION["login_monitor"]){
    echo "<script type='text/javascript'>";
    echo "alert('權限不足，無法修改!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=".$message_No."'/>";
    exit;
}
?>

<br>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h1>回覆內容修改</h1>
        <!-- 警告內容：失敗 -->
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
        <form action="message_reply_update_confirm.php" method="POST">
            <input type="hidden" name="No" value="<?php echo $message_No; ?>">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">回覆內容</label>
                <div class="col-sm-10">
                    <textarea type="text" name="回覆內容" class="form-control" required rows="15"><?php echo $row['回覆內容']; ?></textarea>
                </div>
            </div>
            <input type="submit" value="確認修改" class="form-control btn btn-primary">
        </form>
        <br>
        <br>&nbsp;
    </div>
    <div class="col-md-2"></div>
</div>