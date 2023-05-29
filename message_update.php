<?php
session_start();
require('dbconnect.php');

$title = "留言修改";
require('layout/header.php');

//HTTP-GET
$message_No = $_GET['No'];
$SQL = "SELECT 標題, 內容, 回覆內容, 學號
        FROM 留言
        WHERE No=$message_No";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);

//Check：必須是留言者本人才可修改
if(!isset($_SESSION['login_identity']) || $row["學號"] != $_SESSION["login_account"]){
    echo "<script type='text/javascript'>";
    echo "alert('權限不足，無法修改!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=".$message_No."'/>";
    exit;
}
//Check：訊息已被回覆後無法修改
if($row["回覆內容"] != NULL){
    echo "<script type='text/javascript'>";
    echo "alert('此訊息已被回覆，無法修改!')";
    echo '</script>';
    echo "<meta http-equiv='Refresh'; content='0; url=message_content?No=".$message_No."'/>";
    exit;
}
?>


<br>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h1>留言修改</h1>
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
        <form action="message_update_confirm.php" method="POST">
            <input type="hidden" name="No" value="<?php echo $message_No; ?>">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">留言標題</label>
                <div class="col-sm-10">
                    <input type="text" name="留言標題" class="form-control" required value="<?php echo $row['標題']; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">留言事項</label>
                <div class="col-sm-10">
                    <textarea type="text" name="留言事項" class="form-control" required rows="15"><?php echo $row['內容']; ?></textarea>
                </div>
            </div>
            <input type="submit" value="確認修改" class="form-control btn btn-primary">
        </form>
        <br>
        <br>&nbsp;
    </div>
    <div class="col-md-2"></div>
</div>