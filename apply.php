<?php

//Check："學生"才可使用本頁面
session_start();
if(!isset($_SESSION['login_identity']) || $_SESSION['login_identity'] != "學生" && $_SESSION['login_identity'] != "舍監"){
    header('Location: login');
    exit();
}
$uAccount = $_SESSION['login_account'];

//確認是否已申請過
require('dbconnect.php');
require('time.php');
$SQL = "SELECT 學號
        FROM 入住申請
        WHERE 學號='$uAccount' AND 學年度='$year' AND 學期='$semester'";
$result = mysqli_query($link, $SQL);
if(mysqli_num_rows($result) > 0){
    header('Location: applied');
    exit();
}

$title = "申請住宿";
require("layout/header.php");
?>

<br>
<div class="row">
    <h1>申請住宿</h1>
    <div class="col-lg-6">
        <img src="pic/domitory_rule1.jpg" alt="宿舍規定圖片1" width="100%">
    </div>
    <div class="col-lg-6">
        <img src="pic/domitory_rule2.jpg" alt="宿舍規定圖片2" width="100%">
    </div>
</div>
<br>
<div style="text-align: center;">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#apply_model">
        申請住宿
    </button>

    <?php
    if (isset($_SESSION['msg'])) {
        echo "<span style='color: red;'>" . $_SESSION['msg'] . "</span>";
        $_SESSION['msg'] = null;
    }
    ?>
</div>
<br>

<!-- Modal -->
<div class="modal fade" id="apply_model">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">宿舍公約</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                是否同意以上住宿生活公約
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">不同意</button>
                <a href="apply_confirm.php" type="button" class="btn btn-primary">同意</a>
            </div>
        </div>
    </div>
</div>

<?php
require("layout/footer.php");
?>