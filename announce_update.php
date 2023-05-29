<?php
session_start();
require('dbconnect.php');

//Check："系統管理員"、"舍監" 才可使用
if (!isset($_SESSION['login_identity']) || ($_SESSION['login_identity'] != "系統管理員" && $_SESSION['login_identity'] != "舍監")) {
    header('Location: login');
    exit;
}

$title = "公告內容";
require('layout/header.php');

$announce_No = $_GET['No'];
$SQL = "SELECT 標題, 內容
        FROM 系統消息
        WHERE No=$announce_No";
$result = mysqli_query($link, $SQL);
$row = mysqli_fetch_assoc($result);
?>


<br>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h1>修改公告</h1>
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
        <form action="announce_update_confirm.php" method="POST">
            <input type="hidden" name="No" value="<?php echo $announce_No; ?>">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">公告標題</label>
                <div class="col-sm-10">
                    <input type="text" name="公告標題" class="form-control" required value="<?php echo $row['標題']; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">公告事項</label>
                <div class="col-sm-10">
                    <textarea type="text" name="公告事項" class="form-control" required rows="15"><?php echo $row['內容']; ?></textarea>
                </div>
            </div>
            <input type="submit" value="確認修改" class="form-control btn btn-primary">
        </form>
        <br>
        <br>&nbsp;
    </div>
    <div class="col-md-2"></div>
</div>